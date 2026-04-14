    // Establecer el mes actual por defecto en el input
    const hoy = new Date();
    const mesActual = hoy.toISOString().substring(0, 7); // Formato "2026-04"
    selectorMes.value = mesActual;