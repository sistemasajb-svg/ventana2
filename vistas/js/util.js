/* ALERTAS */
function alerta(title, icon, timer) {
  var opts = { title: title, icon: icon || 'success' };
  if (timer) { opts.timer = timer; opts.showConfirmButton = false; }
  return Swal.fire(opts);
}

function alertaExito(title, timer) {
  return alerta(title, 'success', timer || 1500);
}

function alertaError(title) {
  return alerta(title, 'error');
}

function alertaAdvertencia(title) {
  return alerta(title, 'warning');
}

function alertaConfirmar(title, text, callback) {
  Swal.fire({
    title: title,
    text: text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Sí',
    cancelButtonText: 'Cancelar'
  }).then(function (result) {
    if (result.isConfirmed && callback) callback();
  });
}

/* PLUGIN DATATABLE */
function initDataTable(selector, columnFilters) {
  var columns = [];
  $(selector + ' thead th').each(function () {
    columns.push({ title: $(this).text() });
  });

  $('<style>.dt-toolbar{display:flex;flex-wrap:wrap;align-items:center;gap:5px}.dt-toolbar .dataTables_filter{margin-left:auto}.dt-toolbar .dataTables_length label{font-weight:400;margin:0}.dt-toolbar .btn-group{margin:0}.dt-toolbar .btn-xs{padding:1px 5px;font-size:12px;line-height:1.5}</style>').appendTo('head');

  var table = $(selector).DataTable({
    columns: columns,
    language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json' },
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    dom: "<'row'<'col-sm-12'<'dt-toolbar'lBf>>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      { extend: 'copy', text: '<i class="fa fa-copy"></i>', className: 'btn-xs', titleAttr: 'Copiar' },
      { extend: 'excel', text: '<i class="fa fa-file-excel-o"></i>', className: 'btn-xs', titleAttr: 'Excel' },
      { extend: 'pdf', text: '<i class="fa fa-file-pdf-o"></i>', className: 'btn-xs', titleAttr: 'PDF' },
      { extend: 'print', text: '<i class="fa fa-print"></i>', className: 'btn-xs', titleAttr: 'Imprimir' },
      { extend: 'colvis', text: '<i class="fa fa-eye"></i>', className: 'btn-xs', titleAttr: 'Columnas' }
    ]
  });

  if (columnFilters) {
    Object.keys(columnFilters).forEach(function (col) {
      $(columnFilters[col]).on('keyup change', function () {
        table.column(parseInt(col)).search($(this).val()).draw();
      });
    });
  }

  return table;
}