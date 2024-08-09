@include('admin/layout.head')

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('admin/layout.sidebar')
      <div class="layout-page">
        @include('admin/layout.navbar')

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('contents')
          </div>
          @include('admin/layout.footer')