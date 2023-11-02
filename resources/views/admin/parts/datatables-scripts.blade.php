<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $("#datatables").DataTable({
            oLanguage: {
                sSearch: "Cauta utilizatori:"
            },
            language: {
                info: "Se afiseaza pagina _PAGE_ din _PAGES_",
                infoFiltered: "(filtrat din _MAX_ intrări)",
                lengthMenu: "Afiseaza _MENU_ randuri / pagina",
                paginate: {
                    next: "Urm",
                    first: "Prima",
                    last: "Ultima",
                    previous: "Prec"
                }
            }
        });
    });
</script>