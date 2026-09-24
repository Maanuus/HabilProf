<div id="sync-notification-container" class="mb-6"></div>

<script>
let lastNotificationId = localStorage.getItem('last_shown_notification_id') || '';
let dismissedNotifications = JSON.parse(localStorage.getItem('dismissed_notifications') || '[]');

function dismissNotification(id) {
    dismissedNotifications.push(id);
    localStorage.setItem('dismissed_notifications', JSON.stringify(dismissedNotifications));
    document.getElementById(id)?.remove();
}

function showNotification(data) {
    if (!data || !data.notification) return;
    
    const notificationId = data.id;
    if (dismissedNotifications.includes(notificationId)) return;
    if (notificationId === lastNotificationId) return;
    
    const notification = data.notification;
    const container = document.getElementById('sync-notification-container');
    
    let isError = !!notification.error;
    let containerClass = isError 
        ? 'bg-red-50 border-red-300 text-red-800' 
        : 'bg-blue-50 border-blue-200 text-blue-900';
    let iconSvg = isError
        ? `<svg class="w-5 h-5 text-red-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>`
        : `<svg class="w-5 h-5 text-blue-600 mr-3 shrink-0 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>`;
    
    let contentHtml = isError
        ? `<div><p class="font-bold text-sm">Error en sincronización</p><p class="text-xs mt-0.5">${notification.error}</p></div>`
        : `<div>
             <div class="flex items-center space-x-2">
                 <span class="font-bold text-sm">Sincronización completada</span>
                 <span class="text-xs text-blue-600 font-mono">(${notification.timestamp})</span>
             </div>
             <div class="text-xs mt-1 text-blue-700 flex flex-wrap gap-x-3 gap-y-0.5">
                 <span>Alumnos: <strong>+${notification.alumnos_creados || 0} / ${notification.alumnos} act</strong></span>
                 <span>Profesores: <strong>+${notification.profesores_creados || 0} / ${notification.profesores} act</strong></span>
                 <span>Notas: <strong>${notification.notas_total}</strong> (Aprobadas: ${notification.notas_aprobadas}, Reprobadas: ${notification.notas_reprobadas})</span>
             </div>
           </div>`;

    container.innerHTML = `
        <div id="${notificationId}" class="flex items-center justify-between p-4 border rounded-xl shadow-xs transition duration-200 ${containerClass}">
            <div class="flex items-center">
                ${iconSvg}
                ${contentHtml}
            </div>
            <button type="button" onclick="dismissNotification('${notificationId}')" class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-black/5 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `;
    
    lastNotificationId = notificationId;
    localStorage.setItem('last_shown_notification_id', notificationId);
}

function checkForNewNotifications() {
    fetch('{{ route('api.sync.notification') }}')
        .then(res => res.json())
        .then(data => showNotification(data))
        .catch(err => console.error('Error polling sync notification:', err));
}

checkForNewNotifications();
setInterval(checkForNewNotifications, 5000);
</script>
