document.addEventListener('DOMContentLoaded', () => {
  const tipoSel        = document.getElementById('tipo_HabilProf');
  const grupoProyecto  = document.getElementById('grupoProyecto');
  const grupoPractica  = document.getElementById('grupoPractica');

  const reqProyectoIds = ['titulo','descripcion','rut_profesor_comision','semestre_inicio'];
  const reqPracticaIds = ['nombre_Empresa','nombre_Supervisor'];

  function setRequired(ids, on){
    ids.forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      el.required = on;
      if (!on){
        el.value = '';
        el.setCustomValidity('');
        el.classList.remove('is-invalid','is-valid');
      }
    });
  }

  function normalize(v){
    if(!v) return '';
    const s = v.toString().trim().toUpperCase();
    if (s === 'PRTUT' || s.includes('PRÁCTICA') || s.includes('PRACTICA')) return 'PrTut';
    if (s === 'PRING' || s.includes('INGENIER')) return 'PrIng';
    if (s === 'PRINV' || s.includes('INVESTIG')) return 'PrInv';
    return v;
  }

  function toggle(){
    const raw = tipoSel?.value || '';
    const val = normalize(raw);
    const esProyecto = (val === 'PrIng' || val === 'PrInv');
    const esPractica = (val === 'PrTut');

    if (grupoProyecto) grupoProyecto.hidden = !esProyecto;
    if (grupoPractica) grupoPractica.hidden = !esPractica;

    setRequired(reqProyectoIds, esProyecto);
    setRequired(reqPracticaIds, esPractica);

    console.log('[toggle]', { raw, val, esProyecto, esPractica,
      hiddenProyecto: grupoProyecto?.hidden, hiddenPractica: grupoPractica?.hidden });
  }

  if (tipoSel){
    tipoSel.addEventListener('change', toggle);
    toggle(); // estado inicial
  } else {
    console.warn('No se encontró #tipo_HabilProf');
  }
});
