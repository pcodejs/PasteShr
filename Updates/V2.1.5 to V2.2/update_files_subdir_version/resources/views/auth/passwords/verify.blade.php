<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('front.includes.head')
<body>

<main>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4 text-center">Purchase Code Verification</div>

                <div class="card-body">
                    @include('front.includes.messages')
                    <form method="POST">
                        @csrf
                      <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Purchase Code</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="code" placeholder="Enter Purchase Code" required autofocus>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                          <button class="btn btn-success">Verify</button>
                        </div>
                      </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@include('front.includes.foot')
</body>
</html>
