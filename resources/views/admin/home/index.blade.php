@extends('admin.app.main')
@section('main')
<div class="row">
    {{-- <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 p-1">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Kemasukan</p>
                <h5 class="font-weight-bolder">
                  Rp 0
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                  <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 p-1">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pengeluaran</p>
                <h5 class="font-weight-bolder">
                  Rp 0
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  <i class="ni ni-spaceship text-lg opacity-10" aria-hidden="true"></i>
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div> --}}
   
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 p-1">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Lunas</p>
                <h5 class="font-weight-bolder">
                  Rp. {{ number_format($lunas, 0, ',', '.') }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 p-1">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Proses</p>
                <h5 class="font-weight-bolder">
                  Rp. {{ number_format($proses, 0, ',', '.') }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                  <i class="ni ni-settings-gear-65 text-lg opacity-10" aria-hidden="true"></i>
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 p-1">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Barang Service</p>
                <h5 class="font-weight-bolder">
                  {{ $total }} Unit
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                  <i class="ni ni-laptop text-lg opacity-10" aria-hidden="true"></i>
              </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection