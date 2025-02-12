
$(document).ready(function() {
    $('.dataTableExport').each(function() {
        var table = $(this).DataTable({
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip',
            pageLength: 10, // Pagination à 10 éléments
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclure la colonne "Actions"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclure la colonne "Actions"
                    },
                    customize: function(doc) {
                        var columnCount = $(this).find('thead th').length;
                        var columnWidths = Array(columnCount).fill('10%'); // Répartir équitablement

                        doc.content[1].table.widths = columnWidths;
                        doc.styles.tableHeader.fontSize = 7;
                        doc.styles.tableBodyEven.fontSize = 6;
                        doc.styles.tableBodyOdd.fontSize = 6;
                    }
                }
            ],
            language: {
                paginate: { previous: "Précédent", next: "Suivant" },
                lengthMenu: "Afficher _MENU_ enregistrements par page",
                zeroRecords: "Aucun enregistrement trouvé",
                info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                infoEmpty: "Aucun enregistrement disponible",
                infoFiltered: "(filtré de _MAX_ enregistrements au total)"
            }
        });

        // Déplacer les boutons vers le conteneur dédié si existe
        var exportContainer = $(this).closest('.container').find('#exportButtons');
        if (exportContainer.length) {
            table.buttons().container().appendTo(exportContainer);
        }
    });
});

