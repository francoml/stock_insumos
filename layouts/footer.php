     </div>
     </div>
     <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="libs/js/functions.js"></script> -->

     <!-- Latest compiled and minified JavaScript -->
     <script src="libs/jquery.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
     <script src="libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script type="text/javascript" src="libs/js/functions.js"></script>

     <!-- Script que cumple la función de autocomplete filtering -->
     <script>
        $(document).ready(function() {
           $("#miInput").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#miTabla tr").filter(function() {
                 $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
           });
        });
     </script>


     <script>
        $(document).ready(function() {
           $("#miProv").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#miTablita tr").filter(function() {
                 $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
           });
        });
     </script>
     </body>

     </html>

     <?php if (isset($db)) {
         $db->db_disconnect();
      } ?>