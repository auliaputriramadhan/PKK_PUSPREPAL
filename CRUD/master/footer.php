</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
  
    <!-- custom script --> 
    <script>
        $(document).ready(function() {
            $("#postForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 10,
                    },
                    description:{
                        required: true,
                        minlength: 20,
                    }
                },
                messages: {
                    title: {
                        required: "Title is required",
                        minlength: "Title cannot be less than 10 characters"
                    },
                    description: {
                        required: "Description is required",
                        minlength: "Description cannot be less than 20 characters"
                    },
                }
            });
        });
    </script>
</body>
</html>