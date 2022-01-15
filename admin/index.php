<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <form class="card-body p-5" action="handle/processLogin.php" method="POST">

                            <h3 class="mb-5">Sign in</h3>

                            <div class="form-outline mb-4">
                                <input name="username" type="text" id="typeEmailX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typeEmailX-2">Username</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input me-4" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" for="form1Example3"> Remember password </label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>