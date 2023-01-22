@extends('main')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="d-lg-none navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->

                <!-- Topbar Navbar -->

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid mt-3">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    @if (request()->is('detail'))
                        <button class="d-none d-sm-inline-block btn btn-danger shadow-sm"
                            onclick="deleteWisata({{ $data->id }})"><i class="fas fa-trash"></i>
                            Hapus Data</button>
                    @endif
                </div>


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        @if (request()->is('tambah-objek'))
                            <h6 class="m-0 font-weight-bold text-primary">Objek Wisata</h6>
                        @else
                            <div class="">
                                <input type="text" class="form-control value-black nama-wisata"
                                    value="{{ $data->nama_wisata }}">
                            </div>
                        @endif
                    </div>
                    <div class="card-body text-dark">
                        @if (request()->is('tambah-objek'))
                            <form action="/save-baru" method="post">
                                @csrf
                                <label>Nama Objek Wisata</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="nama">
                                    <button class="btn btn-success" type="submit">Tambah</button>
                                </div>
                            </form>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control value-black" rows="5" disabled></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Map</label>
                                <input type="text" class="form-control value-black" disabled>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-3 text-center">
                                    <img src="" alt="gambar..." class="img-thumbnail rounded">
                                </div>
                                <div class="col-lg-9">
                                    <label for="formFileMultiple" class="form-label">Foto</label>
                                    <div class="input-group">
                                        <input type="file" name="foto" class="form-control"
                                            accept="image/png, image/gif, image/jpeg" required disabled>
                                        <button class="btn btn-primary" type="submit" disabled>Upload</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="formFileMultiple" class="form-label">Attachment</label>
                                <div class="input-group">
                                    <input type="file" name="attach[]" class="form-control" multiple
                                        accept="image/png, image/gif, image/jpeg" required disabled>
                                    <button class="btn btn-primary" type="submit" disabled>Upload</button>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control value-black" rows="5" onblur="updateDeskripsi(value,{{ $data->id }})"
                                    {{ request()->is('tambah-objek') ? 'disabled' : '' }}>{{ $data->deskripsi }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Map</label>
                                <input type="text" class="form-control value-black"
                                    onblur="updateLink(value,{{ $data->id }})"
                                    {{ request()->is('tambah-objek') ? 'disabled' : '' }} value="{{ $data->maps }}">
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-3 text-center">
                                    <img src="images/{{ $data->foto }}" alt="gambar..." class="img-thumbnail rounded">
                                </div>
                                <div class="col-lg-9">
                                    <label for="formFileMultiple" class="form-label">Foto</label>
                                    <form action="/edit-foto/{{ $data->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" name="foto" class="form-control"
                                                {{ request()->is('tambah-objek') ? 'disabled' : '' }}
                                                accept="image/png, image/gif, image/jpeg" required>
                                            <button class="btn btn-primary" type="submit">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="formFileMultiple" class="form-label">Attachment</label>
                                <form action="/edit-attach/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="file" name="attach[]" class="form-control" multiple
                                            {{ request()->is('tambah-objek') ? 'disabled' : '' }}
                                            accept="image/png, image/gif, image/jpeg" required>
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                            <div class="row justify-content-around">
                                @foreach ($attach as $item)
                                    <div class="col-sm-11 col-md-5 col-lg-4">
                                        <div class="cardz mb-5">
                                            <div class="cardz-details">
                                                <img src="images/{{ $item->attach_name }}" class="rounded"
                                                    alt="" width="100%" height="100%">
                                            </div>
                                            <button class="cardz-button btn-danger"
                                                onclick="deleteAttach({{ $item->id }})">Delete</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <img src="images/{{ $data->qr_code }}" alt="qr-code" class="img-thumbnail rounded"
                                    width="200">
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
@endsection
