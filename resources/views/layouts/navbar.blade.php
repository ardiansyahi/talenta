@php use App\Models\AksesModel; @endphp
@php
    $akses = AksesModel::find(Session::get('id_akses'));
@endphp

<aside class="app-navbar">
    <!-- begin sidebar-nav -->
    <div class="sidebar-nav scrollbar scroll_light">
        <ul class="metismenu " id="sidebarNav">
            <li><a href="/" aria-expanded="false"><i class="nav-icon fa fa-home"></i><span
                        class="nav-title">Home</span></a>
            </li>
            @if (array_search('1', json_decode($akses->id_form)))
                <li class='{{ Request::segment(1) == 'hitung-krs' || Request::segment(1) == 'master' ? 'active' : '' }}'>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="nav-icon fa fa-database"></i>
                        <span class="nav-title">Data Master</span>
                    </a>
                    <ul aria-expanded="false">
                        @if (array_search('5', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'tikpot' ? 'active' : '' }}'> <a
                                    href='{{ route('master/tikpot') }}'>Titik Potong</a> </li>
                        @endif
                        @if (array_search('6', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'pegawai' ? 'active' : '' }}'> <a
                                    href='{{ route('master/pegawai') }}'>Pegawai</a> </li>
                        @endif
                        @if (array_search('7', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(2) == 'penkom' || Request::segment(2) == 'penkom-upload' || Request::segment(2) == 'penkom-view' ? 'active' : '' }}'>
                                <a href='{{ route('master/penkom') }}'>Upload Penkom</a>
                            </li>
                        @endif
                        @if (array_search('8', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'rw-diklat' ? 'active' : '' }}'> <a
                                    href='{{ route('master/rw-diklat') }}'>RW Diklat</a> </li>
                        @endif
                        @if (array_search('9', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'rw-jabatan' ? 'active' : '' }}'> <a
                                    href='{{ route('master/rw-jabatan') }}'>RW Jabatan</a> </li>
                        @endif
                        @if (array_search('10', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'skp' ? 'active' : '' }}'> <a
                                    href='{{ route('master/skp') }}'>SKP</a> </li>
                        @endif
                        @if (array_search('11', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'penilaian-perilaku' ? 'active' : '' }}'> <a
                                    href='{{ route('master/penilaian-perilaku') }}'>Penilaian Perilaku 360</a> </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (array_search('2', json_decode($akses->id_form)))
                <li class='{{ Request::segment(1) == 'talent-mapping' ? 'active' : '' }}'>
                    <a href='{{ route('talent-mapping') }}'><i class="nav-icon fa fa-calendar-check-o"></i><span
                            class="nav-title">Talent Mapping</span></a>
                </li>
            @endif
            @if (array_search('3', json_decode($akses->id_form)))
                <li class='{{ Request::segment(1) == 'report' ? 'active' : '' }}'>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="nav-icon fa fa-file-text"></i>
                        <span class="nav-title">Report</span>
                    </a>
                    <ul aria-expanded="false">
                        @if (array_search('13', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'pegawai' ? 'active' : '' }}'>
                                <a href='{{ route('report/pegawai') }}'>Pegawai</a> </li>
                        @endif
                        @if (array_search('14', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'penkom' ? 'active' : '' }}'>
                                <a href='{{ route('report/penkom') }}'>Penkom</a> </li>
                        @endif
                        @if (array_search('15', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'rw-diklat' ? 'active' : '' }}'>
                                <a href='{{ route('report/rw-diklat') }}'>RW Diklat</a> </li>
                        @endif
                        @if (array_search('16', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'rw-jabatan' ? 'active' : '' }}'>
                                <a href='{{ route('report/rw-jabatan') }}'>RW Jabatan</a> </li>
                        @endif
                        @if (array_search('17', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'skp' ? 'active' : '' }}'>
                                <a href='{{ route('report/skp') }}'>SKP</a>
                            </li>
                        @endif

                        @if (array_search('18', json_decode($akses->id_form)))
                            <li
                                class='{{ Request::segment(1) == 'report' && Request::segment(2) == 'penilaian-perilaku' ? 'active' : '' }}'>
                                <a href='{{ route('report/penilaian-perilaku') }}'>Penilaian Perilaku</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (array_search('4', json_decode($akses->id_form)))
                <li class='{{ Request::segment(1) == 'setting' ? 'active' : '' }}'>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="nav-icon fa fa-gear"></i>
                        <span class="nav-title">Setting</span>
                    </a>
                    <ul aria-expanded="false">
                        @if (array_search('19', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'user' ? 'active' : '' }}'> <a
                                    href='{{ route('setting/user') }}'>User</a> </li>
                        @endif
                        @if (array_search('20', json_decode($akses->id_form)))
                            <li class='{{ Request::segment(2) == 'akses' ? 'active' : '' }}'> <a
                                    href='{{ route('setting/akses') }}'>Hak Akses</a> </li>
                        @endif


                    </ul>
                </li>
            @endif

            <li>
                <a href='{{ route('logout') }}'><i class="nav-icon ion ion-ios-log-out"></i><span class="nav-title">Log
                        Out</span></a>
            </li>
        </ul>
    </div>
    <!-- end sidebar-nav -->
</aside>
