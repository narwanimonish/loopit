<template>
  <div class="row">
    <div class="col">
      <section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
              <form>
                <div class="form-outline mb-4">
                  <label class="form-label" for="email">Email address</label>
                  <input
                    type="email"
                    id="email"
                    class="form-control form-control-lg"
                  />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input
                    type="password"
                    id="password"
                    class="form-control form-control-lg"
                  />
                </div>

                <div class="d-flex justify-content-around align-items-center">
                  <a href="#!">New User? Register here..</a>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                  Sign in
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>
