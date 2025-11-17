<div id="sync-notification-container"></div>

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
    
    // No mostrar si ya fue cerrada
    if (dismissedNotifications.includes(notificationId)) return;
    
    // No mostrar si es la misma que ya se mostró
    if (notificationId === lastNotificationId) return;
    
    const notification = data.notification;
    const container = document.getElementById('sync-notification-container');
    
    let alertClass = 'alert-info';
    let content = '';
    
    if (notification.error) {
        alertClass = 'alert-danger';
        content = `
            <strong>Error en sincronización</strong>
            <p class="mb-0 small">${notification.error}</p>
        `;
    } else {
        content = `
            <strong>Sincronización completada</strong>
            <span class="small text-muted">(${notification.timestamp})</span>
            <div class="small mt-1">
                Alumnos: +${notification.alumnos_creados || 0} / ${notification.alumnos} act | 
                Profesores: +${notification.profesores_creados || 0} / ${notification.profesores} act | 
                Notas: ${notification.notas_total} 
                (Aprobadas: ${notification.notas_aprobadas}, Reprobadas: ${notification.notas_reprobadas})
            </div>
        `;
    }
    
    container.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" id="${notificationId}">
            <div class="d-flex align-items-center">
                <i class="bi bi-arrow-repeat me-2"></i>
                <div class="flex-grow-1">
                    ${content}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="dismissNotification('${notificationId}')"></button>
            </div>
        </div>
    `;
    
    lastNotificationId = notificationId;
    localStorage.setItem('last_shown_notification_id', notificationId);
}

// Polling cada 5 segundos
function checkForNewNotifications() {
    fetch('{{ route('api.sync.notification') }}')
        .then(response => response.json())
        .then(data => showNotification(data))
        .catch(error => console.error('Error fetching notification:', error));
}

// Verificar al cargar la página
checkForNewNotifications();

// Polling cada 5 segundos
setInterval(checkForNewNotifications, 5000);
</script>

