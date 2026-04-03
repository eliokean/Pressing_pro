<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>PressingPro — Service Digital</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0a0b0e;
    --surface: #111318;
    --surface2: #181b22;
    --border: rgba(255,255,255,0.07);
    --accent: #00d4ff;
    --gold: #f59e0b;
    --text: #e8eaf0;
    --muted: #6b7280;
    --danger: #ef4444;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    overflow-x: hidden;
  }

  .app-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    height: 100vh;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px 24px;
    gap: 20px;
  }

  .panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .panel-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .panel-title {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: var(--muted);
  }

  .panel-count {
    background: rgba(0,212,255,0.1);
    color: var(--accent);
    border: 1px solid rgba(0,212,255,0.2);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.78rem;
    font-weight: 500;
  }

  .panel-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    scrollbar-width: thin;
    scrollbar-color: var(--border) transparent;
  }

  .linge-list { display: flex; flex-direction: column; gap: 10px; }

  .linge-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.25s ease;
    cursor: pointer;
  }

  .linge-item:hover {
    border-color: rgba(0,212,255,0.25);
    background: rgba(0,212,255,0.04);
    transform: translateX(3px);
  }

  .linge-item.selected {
    border-color: rgba(0,212,255,0.4);
    background: rgba(0,212,255,0.06);
  }

  .linge-info { display: flex; align-items: center; gap: 14px; }

  .linge-icon {
    width: 36px; height: 36px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
  }

  .linge-icon svg {
    width: 18px; height: 18px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke 0.2s;
  }

  .linge-item:hover .linge-icon { border-color: rgba(0,212,255,0.3); }
  .linge-item:hover .linge-icon svg { stroke: var(--accent); }
  .linge-item.selected .linge-icon { border-color: rgba(0,212,255,0.4); }
  .linge-item.selected .linge-icon svg { stroke: var(--accent); }

  .linge-name { font-weight: 500; font-size: 0.85rem; }
  .linge-category { font-size: 0.75rem; color: var(--muted); margin-top: 2px; }

  .toggle { position: relative; width: 44px; height: 24px; }
  .toggle input { display: none; }

  .toggle-track {
    position: absolute;
    inset: 0;
    border-radius: 50px;
    background: var(--surface);
    border: 1px solid var(--border);
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .toggle-thumb {
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: var(--muted);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .toggle input:checked ~ .toggle-track {
    background: rgba(0,212,255,0.15);
    border-color: var(--accent);
  }

  .toggle input:checked ~ .toggle-track .toggle-thumb {
    background: var(--accent);
    left: 23px;
    box-shadow: 0 0 8px rgba(0,212,255,0.6);
  }

  .panier-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 14px;
  }

  .panier-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.25s ease;
    animation: popIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  @keyframes popIn {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
  }

  .panier-card:hover {
    border-color: rgba(0,212,255,0.3);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
  }

  .panier-img {
    width: 100%;
    height: 100px;
    background: linear-gradient(135deg, #1a1f2e, #0f1219);
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid var(--border);
  }

  .panier-img svg {
    width: 42px; height: 42px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 1.2;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke 0.2s;
  }

  .panier-card:hover .panier-img svg { stroke: var(--accent); }

  .panier-info { padding: 10px; }
  .panier-name { font-size: 0.78rem; font-weight: 500; margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  .qty-control {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
  }

  .qty-btn {
    width: 28px; height: 28px;
    border: none;
    background: transparent;
    color: var(--text);
    cursor: pointer;
    font-size: 1rem;
    font-weight: 700;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center;
  }

  .qty-btn:hover { background: rgba(0,212,255,0.15); color: var(--accent); }
  .qty-btn.minus:hover { background: rgba(239,68,68,0.15); color: var(--danger); }

  .qty-val {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    min-width: 24px;
    text-align: center;
    color: var(--accent);
  }

  /* DELIVERY */
  .delivery-section {
    padding: 12px 20px;
    border-top: 1px solid var(--border);
    background: var(--surface2);
  }

  .delivery-title {
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    font-size: 0.68rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .delivery-title svg { width: 12px; height: 12px; stroke: var(--accent); }

  /* DISTANCE INPUT */
  .distance-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 12px;
    transition: border-color 0.2s;
  }

  .distance-row:focus-within {
    border-color: rgba(0,212,255,0.4);
  }

  .distance-row svg {
    width: 16px; height: 16px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    transition: stroke 0.2s;
  }

  .distance-row:focus-within svg { stroke: var(--accent); }

  .distance-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--text);
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    min-width: 0;
  }

  .distance-input::placeholder { color: var(--muted); font-weight: 400; font-family: 'DM Sans', sans-serif; }

  .distance-input::-webkit-inner-spin-button,
  .distance-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
  .distance-input[type=number] { -moz-appearance: textfield; }

  .distance-unit {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
  }

  .distance-km {
    font-size: 0.68rem;
    color: var(--accent);
    font-weight: 500;
    white-space: nowrap;
    min-width: 48px;
    text-align: right;
  }

  .delivery-options { display: flex; gap: 8px; }

  .delivery-option { flex: 1; position: relative; }

  .delivery-option input { position: absolute; opacity: 0; pointer-events: none; }

  .delivery-card {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    background: var(--surface);
    border: 2px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .delivery-card:hover { border-color: rgba(0,212,255,0.3); }

  .delivery-option input:checked + .delivery-card {
    border-color: var(--accent);
    background: rgba(0,212,255,0.06);
  }

  .delivery-icon {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .delivery-icon svg {
    width: 20px; height: 20px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke 0.2s;
  }

  .delivery-option input:checked + .delivery-card .delivery-icon svg { stroke: var(--accent); }

  .delivery-info { display: flex; flex-direction: column; gap: 1px; }

  .delivery-label { font-weight: 600; font-size: 0.72rem; color: var(--text); }

  .delivery-option input:checked + .delivery-card .delivery-label { color: var(--accent); }

  .delivery-price {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    color: var(--gold);
  }

  /* SUMMARY */
  .summary-bar {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .summary-stat { display: flex; flex-direction: column; gap: 2px; }
  .stat-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); }
  .stat-val { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.95rem; }
  .stat-val.accent { color: var(--accent); }
  .stat-val.gold { color: var(--gold); }

  .btn-confirm {
    background: linear-gradient(135deg, var(--accent), #0099cc);
    color: #000;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s;
  }

  .btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,212,255,0.35);
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 12px;
    color: var(--muted);
    opacity: 0;
    animation: fadeIn 0.4s 0.3s forwards;
  }

  @keyframes fadeIn { to { opacity: 1; } }

  .cat-divider {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
    padding: 4px 0 8px;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cat-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

  .search-bar { padding: 12px 20px; border-bottom: 1px solid var(--border); }

  .search-input {
    width: 100%;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px 10px 36px;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    outline: none;
    transition: border-color 0.2s;
  }

  .search-wrap { position: relative; }
  .search-wrap::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px; height: 16px;
    border: 2px solid var(--muted);
    border-radius: 50%;
    border-right-color: transparent;
  }

  .search-input:focus { border-color: rgba(0,212,255,0.4); }

  .toast {
    position: fixed;
    bottom: 32px; right: 32px;
    background: var(--surface2);
    border: 1px solid rgba(0,212,255,0.3);
    border-radius: 14px;
    padding: 14px 20px;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 999;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s;
    pointer-events: none;
  }

  .toast.show { opacity: 1; transform: translateY(0); }

  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

  @media (max-width: 768px) {
    .app-layout { grid-template-columns: 1fr; height: auto; min-height: 100vh; }
    .delivery-options { flex-direction: column; }
    .summary-bar { flex-wrap: wrap; gap: 10px; }
    .btn-confirm { width: 100%; text-align: center; }
  }
</style>
</head>
<body>

<div class="app-layout">

  <!-- LEFT PANEL : Sélection du linge -->
  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">Sélection du linge</span>
      <span class="panel-count" id="selected-count">0 sélectionné</span>
    </div>
    <div class="search-bar">
      <div class="search-wrap">
        <input type="text" class="search-input" placeholder="Rechercher un article..." oninput="filterItems(this.value)">
      </div>
    </div>
    <div class="panel-body">
      <div class="linge-list" id="linge-list">

        @forelse($lingesParCategorie as $categorie => $linges)

          <div class="cat-divider">
            {{ $categorie === 'Vêtements' ? 'Vêtements' : 'Maisons' }}
          </div>

          @foreach($linges as $linge)
            <div class="linge-item" data-id="{{ $linge->id }}" data-name="{{ $linge->nom }}">
              <div class="linge-info">
                <div class="linge-icon">
                  @if($linge->categorie === 'Vêtements')
                    <svg viewBox="0 0 24 24">
                      <path d="M6 3H3L1 8l3 1v11h16V9l3-1-2-5h-3s-1 3-5 3-5-3-5-3z"/>
                    </svg>
                  @else
                    <svg viewBox="0 0 24 24">
                      <rect x="2" y="7" width="20" height="13" rx="2"/>
                      <path d="M2 13h20"/>
                    </svg>
                  @endif
                </div>
                <div>
                  <div class="linge-name">{{ $linge->nom }}</div>
                  <div class="linge-category">
                    {{ $linge->getCategorieLibelle() }} — {{ number_format($linge->prix, 0, ',', ' ') }} F
                  </div>
                </div>
              </div>
              <label class="toggle">
                <input type="checkbox"
                  onchange="toggleItem(
                    this,
                    '{{ $linge->id }}',
                    '{{ addslashes($linge->nom) }}',
                    '{{ $linge->categorie }}',
                    {{ $linge->prix }}
                  )">
                <div class="toggle-track"><div class="toggle-thumb"></div></div>
              </label>
            </div>
          @endforeach

        @empty
          <div style="color:var(--muted); text-align:center; padding:20px; font-size:0.85rem;">
            Aucun article disponible.
          </div>
        @endforelse

      </div>
    </div>
  </div>

  <!-- RIGHT PANEL : Panier -->
  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">Panier</span>
      <span class="panel-count" id="panier-count">0 article</span>
    </div>
    <div class="panel-body" id="panier-body">
      <div class="empty-state" id="empty-state">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.2">
          <path d="M6 3H3L1 8l3 1v11h16V9l3-1-2-5h-3s-1 3-5 3-5-3-5-3z"/>
        </svg>
        <div>Sélectionnez des articles</div>
      </div>
      <div class="panier-grid" id="panier-grid"></div>
    </div>

    <!-- SECTION LIVRAISON -->
    <div class="delivery-section">
      <div class="delivery-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
        </svg>
        Livraison
      </div>

      <div class="distance-row">
        <svg viewBox="0 0 24 24">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
          <circle cx="12" cy="9" r="2.5"/>
        </svg>
        <input
          type="number"
          class="distance-input"
          id="distance-input"
          placeholder="Distance de livraison"
          min="0"
          step="100"
          oninput="updateSummary()">
        <span class="distance-unit">m</span>
        <span class="distance-km" id="distance-km">— km</span>
      </div>

      <div class="delivery-options">
        @foreach($vehicules as $index => $vehicule)
          <label class="delivery-option">
            <input
              type="radio"
              name="delivery"
              value="{{ $vehicule->type }}"
              data-coefficient="{{ $vehicule->coefficient }}"
              {{ $index === 0 ? 'checked' : '' }}>
            <div class="delivery-card">
              <div class="delivery-icon">
                @if($vehicule->type === 'Vélo')
                  <svg viewBox="0 0 24 24">
                    <circle cx="5" cy="17" r="3"/>
                    <circle cx="19" cy="17" r="3"/>
                    <path d="M12 17V7l4 4"/>
                    <path d="M8 17l4-6"/>
                  </svg>
                @elseif($vehicule->type === 'Moto')
                  <svg viewBox="0 0 24 24">
                    <circle cx="5" cy="17" r="2.5"/>
                    <circle cx="19" cy="17" r="2.5"/>
                    <path d="M5 17h3l2-4h4l1 2h3"/>
                    <path d="M8 13l3-5h2l2 5"/>
                  </svg>
                @else
                  <svg viewBox="0 0 24 24">
                    <path d="M5 17h14v-5l-2-4H7l-2 4v5z"/>
                    <circle cx="7.5" cy="17" r="1.5"/>
                    <circle cx="16.5" cy="17" r="1.5"/>
                  </svg>
                @endif
              </div>
              <div class="delivery-info">
                <span class="delivery-label">{{ $vehicule->typeLibelle }}</span>
                <span class="delivery-price" id="delivery-price-{{ $vehicule->type }}">
                  ×{{ $vehicule->coefficient }}
                </span>
              </div>
            </div>
          </label>
        @endforeach
      </div>
    </div>

    <!-- BARRE RÉCAPITULATIVE -->
    <div class="summary-bar">
      <div class="summary-stat">
        <span class="stat-label">Articles</span>
        <span class="stat-val accent" id="total-articles">0</span>
      </div>
      <div class="summary-stat">
        <span class="stat-label">Pièces</span>
        <span class="stat-val" id="total-pieces">0</span>
      </div>
      <div class="summary-stat">
        <span class="stat-label">Sous-total</span>
        <span class="stat-val" id="subtotal-price">0 F</span>
      </div>
      <div class="summary-stat">
        <span class="stat-label">Livraison</span>
        <span class="stat-val" id="delivery-display">0 F</span>
      </div>
      <div class="summary-stat">
        <span class="stat-label">Total</span>
        <span class="stat-val gold" id="total-price">0 F</span>
      </div>
      <button class="btn-confirm" onclick="confirmer()">Confirmer</button>
    </div>
  </div>

</div>

<div class="toast" id="toast">
  <span id="toast-icon">✓</span>
  <span id="toast-msg">Message</span>
</div>

<script>
  // ─── CSRF TOKEN ──────────────────────────────────────────────────────────────
  const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // ─── ICÔNES SVG par catégorie ────────────────────────────────────────────────
  const SVGS = {
    vetement: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 3H3L1 8l3 1v11h16V9l3-1-2-5h-3s-1 3-5 3-5-3-5-3z"/></svg>',
    maison:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="13" rx="2"/><path d="M2 13h20"/></svg>',
  };
  const SVG_DEFAULT = SVGS.vetement;

  // ─── ÉTAT ────────────────────────────────────────────────────────────────────
  let cart      = {};
  let calcTimer = null;

  // ─── TOGGLE ARTICLE ──────────────────────────────────────────────────────────
  function toggleItem(cb, id, name, categorie, prix) {
    const item = cb.closest('.linge-item');
    if (cb.checked) {
      item.classList.add('selected');
      cart[id] = { name, categorie, qty: 1, prix: parseInt(prix) };
      addCard(id, name, categorie);
    } else {
      item.classList.remove('selected');
      delete cart[id];
      const card = document.getElementById('card-' + id);
      if (card) card.remove();
    }
    updateSummary();
  }

  // ─── AJOUTER UNE CARTE AU PANIER ─────────────────────────────────────────────
  function addCard(id, name, categorie) {
    document.getElementById('empty-state').style.display = 'none';
    const grid = document.getElementById('panier-grid');
    const card = document.createElement('div');
    card.className = 'panier-card';
    card.id = 'card-' + id;
    const svg = SVGS[categorie] || SVG_DEFAULT;
    card.innerHTML =
      '<div class="panier-img">' + svg + '</div>' +
      '<div class="panier-info">' +
        '<div class="panier-name">' + name + '</div>' +
        '<div class="qty-control">' +
          '<button class="qty-btn minus" onclick="chgQty(\'' + id + '\',-1)">−</button>' +
          '<span class="qty-val" id="qty-' + id + '">1</span>' +
          '<button class="qty-btn" onclick="chgQty(\'' + id + '\',1)">+</button>' +
        '</div>' +
      '</div>';
    grid.appendChild(card);
  }

  // ─── CHANGER QUANTITÉ ────────────────────────────────────────────────────────
  function chgQty(id, d) {
    if (!cart[id]) return;
    cart[id].qty = Math.max(1, cart[id].qty + d);
    document.getElementById('qty-' + id).textContent = cart[id].qty;
    updateSummary();
  }

  // ─── MISE À JOUR DU RÉCAPITULATIF ────────────────────────────────────────────
  function updateSummary() {
    const ids = Object.keys(cart);

    // Compteurs locaux uniquement (pas de montants)
    const pieces = ids.reduce((s, k) => s + cart[k].qty, 0);

    document.getElementById('selected-count').textContent =
      ids.length + ' sélectionné' + (ids.length > 1 ? 's' : '');
    document.getElementById('panier-count').textContent =
      ids.length + ' article' + (ids.length > 1 ? 's' : '');
    document.getElementById('total-articles').textContent = ids.length;
    document.getElementById('total-pieces').textContent   = pieces;
    document.getElementById('empty-state').style.display  = ids.length ? 'none' : 'flex';

    // Affichage de la distance convertie en km
    const distanceM = Math.max(0, parseFloat(document.getElementById('distance-input').value) || 0);
    const kmSpan    = document.getElementById('distance-km');
    if (distanceM > 0) {
      kmSpan.textContent = (distanceM / 1000).toFixed(2).replace('.', ',') + ' km';
      kmSpan.style.color = 'var(--accent)';
    } else {
      kmSpan.textContent = '— km';
      kmSpan.style.color = 'var(--muted)';
    }

    // ── FIX : si panier vide ou distance absente → tout à zéro, sans référencer sousTotal ──
    if (!ids.length || distanceM <= 0) {
      document.getElementById('subtotal-price').textContent   = '0 F';
      document.getElementById('delivery-display').textContent = '0 F';
      document.getElementById('total-price').textContent      = '0 F';
      return;
    }

    // Debounce avant appel API
    clearTimeout(calcTimer);
    calcTimer = setTimeout(() => calculerPrixBackend(distanceM), 400);
  }

  // ─── APPEL API BACKEND ───────────────────────────────────────────────────────
  async function calculerPrixBackend(distanceM) {
    const vehiculeType = document.querySelector('input[name="delivery"]:checked')?.value;
    if (!vehiculeType) return;

    const linges = Object.values(cart).map(item => ({
      prix:     item.prix,
      quantite: item.qty,
    }));

    try {
      const response = await fetch('{{ route("commande.calculer-prix") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN':  CSRF,
          'Accept':        'application/json',
        },
        body: JSON.stringify({
          distance_metres: distanceM,
          vehicule_type:   vehiculeType,
          linges:          linges,
        }),
      });

      if (!response.ok) {
        const err = await response.json();
        console.error('Erreur validation:', JSON.stringify(err.errors, null, 2));
        return;
      }

      const data = await response.json();
      // data = { detail, total_livraison, total_prestation, total_commande }

      // ── FIX : subtotal-price = total_prestation (prix × qty × (1 - N)) ──
      document.getElementById('subtotal-price').textContent =
        Math.round(data.total_prestation).toLocaleString('fr-FR') + ' F';

      // livraison A/R déjà calculée côté backend (× 2 intégré dans PrixCalculator)
      document.getElementById('delivery-display').textContent =
        Math.round(data.total_livraison).toLocaleString('fr-FR') + ' F';

      document.getElementById('total-price').textContent =
        Math.round(data.total_commande).toLocaleString('fr-FR') + ' F';

    } catch (e) {
      console.error('Fetch échoué:', e);
    }
  }

  // ─── FILTRE RECHERCHE ────────────────────────────────────────────────────────
  function filterItems(q) {
    document.querySelectorAll('.linge-item').forEach(item => {
      const name = item.querySelector('.linge-name').textContent.toLowerCase();
      item.style.display = name.includes(q.toLowerCase()) ? 'flex' : 'none';
    });
  }

  // ─── CONFIRMATION ─────────────────────────────────────────────────────────────
  function confirmer() {
    const ids = Object.keys(cart);
    if (!ids.length) { showToast('Panier vide !'); return; }
    const distanceM = parseFloat(document.getElementById('distance-input').value) || 0;
    if (distanceM <= 0) { showToast('Veuillez entrer une distance !'); return; }
    const vehicule = document.querySelector('input[name="delivery"]:checked').value;
    showToast('Commande confirmée — ' + vehicule);
    setTimeout(() => {
      cart = {};
      document.getElementById('panier-grid').innerHTML = '';
      document.getElementById('distance-input').value  = '';
      document.getElementById('distance-km').textContent = '— km';
      document.getElementById('distance-km').style.color = 'var(--muted)';
      document.querySelectorAll('.linge-item input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
        cb.closest('.linge-item').classList.remove('selected');
      });
      updateSummary();
    }, 1200);
  }

  // ─── TOAST ───────────────────────────────────────────────────────────────────
  let toastTimer;
  function showToast(msg) {
    const t = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 2400);
  }

  // Recalcul quand on change de véhicule
  document.querySelectorAll('input[name="delivery"]').forEach(r => {
    r.addEventListener('change', updateSummary);
  });

  // Init
  updateSummary();
</script>
</body>
</html>