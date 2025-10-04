<header class="topbar">
  <div class="left">
    <span class="menu-icon">☰</span>
    <h2>LogTrack – Admin Dashboard</h2>
  </div>
  <div class="right" title="Notifications">🔔</div>
</header>

<style>
  header.topbar {
    position: fixed;
    top: 0;
    left: 220px;              /* ✅ matches sidebar width */
    right: 0;
    height: 60px;
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    z-index: 1000;
  }

  header.topbar .left {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  header.topbar .menu-icon {
    font-size: 22px;
    cursor: pointer;
    color: #374151;
  }

  header.topbar h2 {
    font-size: 18px;
    font-weight: 600;
    color: #166534;  /* ✅ dark green */
    margin: 0;
  }

  header.topbar .right {
    font-size: 20px;
    color: #9ca3af;
    cursor: pointer;
  }
</style>
