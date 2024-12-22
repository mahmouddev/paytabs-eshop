<?php

?>
<footer class="py-5">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 copyright">
            <p>© <?= date("Y"); ?> Foodmart. All rights reserved.</p>
          </div>
          <div class="col-md-6 credit-link text-start text-md-end">
            <p>Made with &hearts; by <a target="_blank" href="mailto:mahmouddev80@gmail.com">mahmouddev80</a></p>
          </div>
        </div>
    </div>

    <!-- Snackbar -->
    <div v-if="snackbar.show" class="snackbar">{{ snackbar.message }}</div>

    <script>

</script>


</footer>

