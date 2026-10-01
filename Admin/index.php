<?php
session_start();
include ("koneksi.php");


// CEK APAKAH USER SUDAH LOGIN
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!--META TAG HTML DAN TITLE-->  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--SCRIPT THEME INITIALIZATION-->
    <script>
      (() => {
        'use strict';
        const STORAGE_KEY = 'lte-theme';
        let stored = null;
        try {
          stored = localStorage.getItem(STORAGE_KEY);
        } catch {
          // localStorage may be unavailable (private mode, sandboxed iframe).
        }
        const prefersDark = globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
        let resolved = 'light';
        if (stored === 'dark' || stored === 'light') {
          resolved = stored;
        } else if (prefersDark) {
          resolved = 'dark';
        }
        document.documentElement.setAttribute('data-bs-theme', resolved);
        document.documentElement.style.colorScheme = resolved;
      })();
    </script>

    <!--META TAG ACCESSIBILITY-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />

    <!--LINK CSS FONTS-->         
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />

    <!--LINK CSS OVERLAY SCROLLBARS-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />

    <!--LINK CSS BOOTSTRAP ICONS-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />

    <!--LINK CSS ADMINLTE-->
    <link rel="stylesheet" href="assets/css/adminlte.min.css" />

    <!--LINK CSS APEXCHARTS-->  
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />

    <!--LINK CSS JSVECTORMAP-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />

    <!--LINK CSS SWEETALERT2-->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css" rel="stylesheet">

    <!--LINK CSS DATATABLES-->
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-3.0.2/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/4.0.2/css/buttons.dataTables.min.css">

  </head>
  <!--BODY LAYOUT FIXED SIDEBAR-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--APP WRAPPER-->
    <div class="app-wrapper">
      <!--NAVBAR HEADER-->  
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <!--NAVBAR MENU TOGGLE-->                           
          <ul class="navbar-nav">
            <li class="nav-item">
              <a
                class="nav-link"
                data-lte-toggle="sidebar"
                href="#"
                role="button"
                aria-label="Toggle sidebar"
              >
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>

          <!--NAVBAR RIGHT MENU-->
          <ul class="navbar-nav ms-auto">
            <!--FULLSCREEN TOGGLE-->
            <li class="nav-item">
              <a
                class="nav-link"
                href="#"
                data-lte-toggle="fullscreen"
                aria-label="Toggle fullscreen"
              >
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
              </a>
            </li>

            <!--COLOR MODE TOGGLE-->
            <li class="nav-item dropdown">
              <a
                class="nav-link"
                href="#"
                id="bd-theme"
                aria-label="Toggle color scheme"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="bd-theme"
                style="--bs-dropdown-min-width: 8rem"
              >
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="light"
                    aria-pressed="false"
                  >
                    <i class="bi bi-sun-fill me-2"></i>
                    Light
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="dark"
                    aria-pressed="false"
                  >
                    <i class="bi bi-moon-fill me-2"></i>
                    Dark
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center active"
                    data-bs-theme-value="auto"
                    aria-pressed="true"
                  >
                    <i class="bi bi-circle-half me-2"></i>
                    Auto
                    <i class="bi bi-check-lg ms-auto d-none"></i>
                  </button>
                </li>
              </ul>
            </li>

            <!--USER MENU DROPDOWN-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="assets/image/sunu.png"
                  class="user-image rounded-circle shadow"
                  alt="Sun Kartika"
                />
                <span class="d-none d-md-inline"><?= $_SESSION['username'] ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--USER HEADER-->
                <li class="user-header text-bg-primary">
                  <img
                    src="assets/image/sunu.png"
                    class="rounded-circle shadow"
                    alt="Sun Kartika"
                  />
                  <p>
                    <?= $_SESSION['role'] ?> - Web Developer
                    <small>Member since Nov. 2023</small>
                  </p>
                </li>
                <!--USER BODY-->
                <li class="user-body">
                  <div class="row">
                    <div class="col-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                </li>
                <!--USER FOOTER-->
                <li class="user-footer">
                  <a href="profile.php" class="btn btn-outline-secondary">Profile</a>
                  <a href="logout.php" class="btn btn-outline-danger float-end">Sign out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!--SIDEBAR NAVIGATION-->
      <?php
include "sidebar.php";
?>
      <!--APP MAIN CONTENT-->
      <?php include "konten.php"; ?>
      <!--FOOTER-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        All rights reserved.
      </footer>
    </div>

    <!--LINK SCRIPT OVERLAY SCROLLBARS-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>

    <!--LINK SCRIPT POPPERJS-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>

    <!--LINK SCRIPT BOOTSTRAP-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>

    <!--LINK SCRIPT ADMINLTE-->
    <script src="assets/js/adminlte.min.js"></script>

    <!--SCRIPT OVERLAY SCROLLBARS CONFIGURATION-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>

    <!--LINK SCRIPT SORTABLEJS-->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      crossorigin="anonymous"
    ></script>

    <!--SCRIPT SORTABLE CONFIGURATION-->
    <script>
      new Sortable(document.querySelector('.connectedSortable'), {
        group: 'shared',
        handle: '.card-header',
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>

    <!--LINK SCRIPT APEXCHARTS-->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>

    <!--SCRIPT CHART CONFIGURATION-->
    <script>
      const sales_chart_options = {
        series: [
          {
            name: 'Digital Goods',
            data: [28, 48, 40, 19, 86, 27, 90],
          },
          {
            name: 'Electronics',
            data: [65, 59, 80, 81, 56, 55, 40],
          },
        ],
        chart: {
          height: 300,
          type: 'area',
          toolbar: {
            show: false,
          },
        },
        legend: {
          show: false,
        },
        colors: ['#0d6efd', '#20c997'],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth',
        },
        xaxis: {
          type: 'datetime',
          categories: [
            '2023-01-01',
            '2023-02-01',
            '2023-03-01',
            '2023-04-01',
            '2023-05-01',
            '2023-06-01',
            '2023-07-01',
          ],
        },
        tooltip: {
          x: {
            format: 'MMMM yyyy',
          },
        },
      };

      const sales_chart = new ApexCharts(
        document.querySelector('#revenue-chart'),
        sales_chart_options,
      );
      sales_chart.render();
    </script>

    <!--LINK SCRIPT JSVECTORMAP-->
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
      integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
      integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
      crossorigin="anonymous"
    ></script>

    <!--SCRIPT WORLD MAP DAN SPARKLINE CHART-->
    <script>
      new jsVectorMap({
        selector: '#world-map',
        map: 'world',
      });

      const option_sparkline1 = {
        series: [
          {
            data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
      sparkline1.render();

      const option_sparkline2 = {
        series: [
          {
            data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
      sparkline2.render();

      const option_sparkline3 = {
        series: [
          {
            data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
      sparkline3.render();
    </script>

    <!--LINK SCRIPT SWEETALERT2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.js"></script>

    <!--SCRIPT SWEETALERT2 NOTIFICATION-->
    <script>
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil') { ?>
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: "Data berhasil disimpan!",
      });
    <?php } elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'edit') { ?>
      Swal.fire({
        icon: "info",
        title: "Berhasil",
        text: "Data berhasil diubah!",
      });
    <?php } elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
      Swal.fire({
        icon: "warning",
        title: "Berhasil",
        text: "Data berhasil dihapus!",
      });
    <?php } elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') { ?>
      Swal.fire({
        icon: "error",
        title: "Gagal",
        text: "Data gagal disimpan!",
      });
    <?php } ?>
    </script>

    <!--LINK SCRIPT DATATABLES-->
    <script src="https://cdn.datatables.net/v/dt/dt-3.0.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/4.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/4.0.2/js/buttons.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake@0.3.11/build/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake@0.3.11/build/vfs_fonts.js"></script>

    <!--SCRIPT DATATABLES INITIALIZATION-->
    <script>
      var tableIds = ['#tabel-user', '#tabel-siswa', '#tabel-kelas', '#tabel-jenis', '#tabel-izin', '#tabel-verifikasi'];
      tableIds.forEach(function(id) {
        var el = document.querySelector(id);
        if (el) {
          new DataTable(id, {
            paging: false,
            info: false,
            layout: {
              topStart: {
                buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5']
              }
            }
          });
        }
      });
    </script>

  </body>
</html>
