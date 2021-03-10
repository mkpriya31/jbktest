
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">JBKTEST Copyright &copy; 2020. All rights reserved.</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
  $(document).ready(function(){
	$(".top-scorer").click(function() {
		$('html,body').animate({
			scrollTop: $(".score-result").offset().top},
			'slow');
	});
	});
  </script>
</body>

</html>