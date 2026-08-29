<?php
declare(strict_types=1);

$userEmail = current_user_email() ?? '';
$hostLabel = app_host_label();
$chrome = '/index.php?page=tariff_query';
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tarifabfrage — Multimodalis</title>
  <link rel="icon" href="/images/multimodalis-logo.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/classic.css" rel="stylesheet">
</head>
<body>
  <div class="app-shell">
    <div class="app-slide" id="app-slide">
    <aside class="sidebar" id="sidebar" aria-label="Hauptnavigation">
      <div class="sidebar-brand">
        <a class="sidebar-brand-link" href="<?= htmlspecialchars($chrome, ENT_QUOTES, 'UTF-8') ?>" title="Multimodalis">
          <img src="/images/multimodalis-logo.png" alt="">
          <span class="sidebar-brand-text">
            <span class="name">Multimodalis</span>
            <span class="tagline">Tariff Intelligence</span>
          </span>
        </a>
        <button type="button" class="btn-icon" id="btn-pin" aria-label="Seitenleiste anheften" aria-pressed="true" title="Seitenleiste anheften">
          <i class="bi bi-pin-angle-fill" aria-hidden="true" data-pin-icon></i>
        </button>
      </div>
      <nav class="sidebar-nav" aria-label="Anwendung">
        <a href="<?= htmlspecialchars($chrome, ENT_QUOTES, 'UTF-8') ?>"><i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard</a>
        <a href="<?= htmlspecialchars($chrome, ENT_QUOTES, 'UTF-8') ?>"><i class="bi bi-newspaper" aria-hidden="true"></i> News-Board</a>
        <div class="nav-section-title" id="tarife-section">Tarife verwalten</div>
        <div class="subnav" role="group" aria-labelledby="tarife-section">
          <a href="/index.php?page=tariff_query" aria-current="page">
            <i class="bi bi-search" aria-hidden="true"></i> Tarifabfrage
          </a>
          <a href="<?= htmlspecialchars($chrome, ENT_QUOTES, 'UTF-8') ?>"><i class="bi bi-table" aria-hidden="true"></i> Tarife</a>
          <a href="<?= htmlspecialchars($chrome, ENT_QUOTES, 'UTF-8') ?>"><i class="bi bi-file-earmark-text" aria-hidden="true"></i> RFQ</a>
        </div>
      </nav>
    </aside>

    <div class="content-wrap">
      <header class="topbar" role="banner">
        <button type="button" class="btn-icon" id="btn-sidebar-toggle" aria-label="Seitenleiste umschalten" aria-controls="sidebar" aria-expanded="true">
          <i class="bi bi-list" aria-hidden="true"></i>
        </button>
        <h1>Tarifabfrage</h1>
        <button type="button" class="btn btn-sm btn-outline-secondary" aria-label="Sprache DE" disabled title="Nur Anzeige">DE</button>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="profil-menu">
            Profil
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profil-menu">
            <li><span class="dropdown-item-text small text-muted"><?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?></span></li>
            <li><span class="dropdown-item-text small text-muted"><?= htmlspecialchars($hostLabel, ENT_QUOTES, 'UTF-8') ?></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><span class="dropdown-item text-muted">Chrome nur — keine Benutzerverwaltung</span></li>
          </ul>
        </div>
      </header>

      <main class="main-area" id="main" aria-label="Tarifabfrage">
        <section class="panel" aria-labelledby="letzte-suchen-heading">
          <h2 id="letzte-suchen-heading">Letzte Suchen</h2>
          <p class="text-muted small mb-0" id="letzte-suchen-empty">Keine gespeicherten Suchen.</p>
        </section>

        <div class="layout-grid">
          <div>
            <form class="panel" id="search-form" method="get" action="/index.php" aria-labelledby="allgemein-heading">
              <input type="hidden" name="page" value="tariff_query">
              <h2 id="allgemein-heading">Allgemeine Auswahl</h2>
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="leistungsdatum" class="form-label">Leistungsdatum</label>
                  <input type="date" class="form-control" id="leistungsdatum" name="leistungsdatum">
                </div>
                <div class="col-md-4">
                  <label for="transport_mode" class="form-label">Transport Mode</label>
                  <select class="form-select" id="transport_mode" name="transport_mode">
                    <option value="">—</option>
                    <option value="rail">Schiene</option>
                    <option value="road">Straße</option>
                    <option value="intermodal">Intermodal</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="bruttogewicht" class="form-label">Bruttogewicht</label>
                  <input type="text" class="form-control" id="bruttogewicht" name="bruttogewicht" placeholder="kg">
                </div>
                <div class="col-12">
                  <span class="form-label d-block" id="hafen-label">Hafen Auswahl</span>
                  <div role="group" aria-labelledby="hafen-label">
                    <button type="button" class="chip hafen-chip" aria-pressed="false">Rotterdam</button>
                    <button type="button" class="chip hafen-chip" aria-pressed="false">Antwerpen</button>
                    <button type="button" class="chip hafen-chip" aria-pressed="false">Hamburg</button>
                    <button type="button" class="chip hafen-chip" aria-pressed="false">Bremerhaven</button>
                    <button type="button" class="chip hafen-chip" aria-pressed="false">Wilhelmshaven</button>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="stellung" class="form-label">Gestellung <span class="req" aria-hidden="true">*</span><span class="visually-hidden">(erforderlich)</span></label>
                  <input type="text" class="form-control" id="stellung" name="stellung" required aria-required="true">
                </div>
                <div class="col-md-6">
                  <label for="abholung" class="form-label">Abholung <span class="req" aria-hidden="true">*</span><span class="visually-hidden">(erforderlich)</span></label>
                  <input type="text" class="form-control" id="abholung" name="abholung" required aria-required="true">
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-search">Tarife suchen</button>
                </div>
              </div>
            </form>

            <section class="panel" aria-labelledby="dispo-heading">
              <h2 id="dispo-heading">Dispo-Filter</h2>
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="reederei" class="form-label">Reederei</label>
                  <input type="text" class="form-control" id="reederei" name="reederei" form="search-form">
                </div>
                <div class="col-md-4">
                  <label for="depots" class="form-label">Depots</label>
                  <input type="text" class="form-control" id="depots" name="depots" form="search-form">
                </div>
                <div class="col-md-4">
                  <label for="terminals" class="form-label">Terminals</label>
                  <input type="text" class="form-control" id="terminals" name="terminals" form="search-form">
                </div>
                <div class="col-md-6">
                  <span class="form-label d-block" id="kundengruppe-label">Verkaufszuschlag Kundengruppe</span>
                  <div role="group" aria-labelledby="kundengruppe-label">
                    <button type="button" class="chip kg-chip" aria-pressed="false">A</button>
                    <button type="button" class="chip kg-chip" aria-pressed="false">B</button>
                    <button type="button" class="chip kg-chip" aria-pressed="false">C</button>
                    <button type="button" class="chip kg-chip" aria-pressed="false">D</button>
                    <button type="button" class="chip kg-chip" aria-pressed="false">E</button>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="vendor" class="form-label">Vendor</label>
                  <input type="text" class="form-control" id="vendor" name="vendor" form="search-form">
                </div>
              </div>
            </section>

            <section class="panel" aria-labelledby="filter-heading">
              <h2 id="filter-heading">Filter</h2>
              <div role="group" aria-label="Preisfilter">
                <button type="button" class="filter-toggle" aria-pressed="false">BestPrice</button>
                <button type="button" class="filter-toggle" aria-pressed="false">Alle Preise</button>
                <button type="button" class="filter-toggle" aria-pressed="false">Kapazitätsanfrage</button>
                <button type="button" class="filter-toggle" aria-pressed="false">Index</button>
              </div>
            </section>

            <section class="panel" aria-labelledby="results-heading">
              <h2 id="results-heading">Ergebnisse</h2>
              <table class="table table-sm mb-0" aria-describedby="results-empty">
                <caption class="visually-hidden">Tarifergebnisse</caption>
                <thead>
                  <tr>
                    <th scope="col">Tarif</th>
                    <th scope="col">Preis</th>
                    <th scope="col">Kapazität</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="3">
                      <p class="empty-results mb-0" id="results-empty" role="status">Keine Ergebnisse.</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>

          <aside class="side-panels" aria-label="Detailpanels">
            <section class="panel" aria-labelledby="preisdetails-heading">
              <h2 id="preisdetails-heading">Preisdetails</h2>
              <p class="text-muted small mb-0">Keine Auswahl.</p>
            </section>
            <section class="panel" aria-labelledby="angebot-heading">
              <h2 id="angebot-heading">Angebotsvorschau</h2>
              <p class="text-muted small mb-0">Keine Vorschau.</p>
            </section>
            <section class="panel" aria-labelledby="einkauf-heading">
              <h2 id="einkauf-heading">Einkaufspreise</h2>
              <p class="text-muted small mb-0">Keine Daten.</p>
            </section>
          </aside>
        </div>
      </main>

      <footer class="app-footer" role="contentinfo">
        <span>© 2026 Acceltra GmbH</span>
        <span>
          <a href="#">Impressum</a> ·
          <a href="#">Datenschutz</a> ·
          <a href="#">AGB</a>
        </span>
      </footer>
    </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      var KEY_PINNED = 'multimodalis.sidebarPinned';
      var KEY_COLLAPSED = 'multimodalis.sidebarCollapsed';
      var toggle = document.getElementById('btn-sidebar-toggle');
      var pin = document.getElementById('btn-pin');
      var pinIcon = pin ? pin.querySelector('[data-pin-icon]') : null;

      function readFlag(key, fallback) {
        try {
          var v = localStorage.getItem(key);
          if (v === null) return fallback;
          return v === '1' || v === 'true';
        } catch (e) {
          return fallback;
        }
      }

      function writeFlag(key, value) {
        try {
          localStorage.setItem(key, value ? '1' : '0');
        } catch (e) { /* ignore */ }
      }

      function isCollapsed() {
        return document.body.classList.contains('sidebar-collapsed');
      }

      function setCollapsed(collapsed) {
        document.body.classList.toggle('sidebar-collapsed', collapsed);
        if (toggle) {
          toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        }
        writeFlag(KEY_COLLAPSED, collapsed);
      }

      function setPinned(pinned) {
        if (!pin) return;
        pin.setAttribute('aria-pressed', pinned ? 'true' : 'false');
        pin.setAttribute('aria-label', pinned ? 'Seitenleiste gelöst (klicken zum Anheften)' : 'Seitenleiste anheften');
        pin.title = pinned ? 'Angeheftet — Seitenleiste bleibt geöffnet' : 'Nicht angeheftet — Einklappen erlaubt';
        if (pinIcon) {
          pinIcon.className = pinned ? 'bi bi-pin-angle-fill' : 'bi bi-pin-angle';
        }
        document.body.classList.toggle('sidebar-pinned', pinned);
        writeFlag(KEY_PINNED, pinned);
      }

      var pinned = readFlag(KEY_PINNED, true);
      var collapsed = readFlag(KEY_COLLAPSED, false);
      if (pinned) collapsed = false;
      setPinned(pinned);
      setCollapsed(collapsed);

      if (toggle) {
        toggle.addEventListener('click', function () {
          if (isCollapsed()) {
            setCollapsed(false);
            return;
          }
          // Collapsing while pinned unpins, then collapses.
          if (pin && pin.getAttribute('aria-pressed') === 'true') {
            setPinned(false);
          }
          setCollapsed(true);
        });
      }

      if (pin) {
        pin.addEventListener('click', function () {
          var next = pin.getAttribute('aria-pressed') !== 'true';
          setPinned(next);
          if (next) {
            setCollapsed(false);
          }
        });
      }

      document.querySelectorAll('.hafen-chip, .kg-chip, .filter-toggle').forEach(function (el) {
        el.addEventListener('click', function () {
          var on = el.getAttribute('aria-pressed') === 'true';
          el.setAttribute('aria-pressed', on ? 'false' : 'true');
          el.classList.toggle('active', !on);
        });
      });
      var form = document.getElementById('search-form');
      if (form) {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          var status = document.getElementById('results-empty');
          if (status) {
            status.textContent = 'Keine Ergebnisse.';
          }
        });
      }
    })();
  </script>
</body>
</html>
