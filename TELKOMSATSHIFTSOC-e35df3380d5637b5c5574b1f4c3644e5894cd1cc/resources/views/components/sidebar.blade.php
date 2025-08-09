<div class="sidebar">
    <h2 style="color: red; text-align: center;">MENU</h2>
    
    <a href="{{ url('/') }}">🏠 Dashboard</a>
    <a href="{{ url('/table') }}">📋 Daftar Berita Acara</a>
    <a href="{{ url('/petugas') }}">📋 Daftar Petugas</a>
    <a href="{{ url('/petugas/create') }}">➕ Tambah Petugas</a>
</div>

<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    margin: 0;
}

/* Professional Sidebar */
.sidebar {
    width: 220px;
    background: #7f1d1d;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    backdrop-filter: blur(10px);
}

/* Subtle entrance animation */
.sidebar {
    animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
    0% {
        transform: translateX(-10px);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Clean menu header */
.sidebar h2 {
    color: #f1f5f9 !important;
    text-align: center !important;
    margin-bottom: 30px;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    opacity: 0.9;
}

/* Subtle underline */
.sidebar h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 1px;
    background: #991b1b;
    transition: all 0.3s ease;
}

.sidebar:hover h2::after {
    width: 60px;
    background: #b91c1c;
}

/* Professional menu items */
.sidebar a {
    display: block;
    color: #fecaca;
    padding: 12px 20px;
    text-decoration: none;
    position: relative;
    margin: 1px 0;
    transition: all 0.2s ease;
    font-weight: 400;
    font-size: 17px;
    border-left: 3px solid transparent;
}

/* Smooth hover effect */
.sidebar a:hover {
    background: rgba(220, 38, 38, 0.2);
    color: #ffffff;
    transform: translateX(4px);
    border-left: 3px solid #dc2626;
}

/* Clean active state */
.sidebar a.active {
    background: rgba(220, 38, 38, 0.25);
    color: #ffffff;
    border-left: 3px solid #dc2626;
    font-weight: 500;
}

/* Subtle focus state */
.sidebar a:focus {
    outline: 2px solid #dc2626;
    outline-offset: -2px;
    background: rgba(220, 38, 38, 0.2);
}

/* Professional separator */
.separator {
    height: 1px;
    background: #991b1b;
    margin: 12px 20px;
    opacity: 0.6;
}

/* Toggle button */
.toggle-btn {
    position: fixed;
    top: 20px;
    left: 240px;
    background: #dc2626;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s ease;
    z-index: 1001;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.toggle-btn:hover {
    background: #b91c1c;
    transform: scale(1.05);
}

/* Collapsed state */
.sidebar.collapsed {
    width: 60px;
    transition: width 0.3s ease;
}

.sidebar.collapsed .toggle-btn {
    left: 80px;
}

.sidebar.collapsed a {
    padding: 12px 10px;
    text-align: center;
    overflow: hidden;
}

.sidebar.collapsed h2 {
    font-size: 0;
    margin-bottom: 20px;
}

/* Tooltip for collapsed items */
.sidebar.collapsed a::after {
    content: attr(data-tooltip);
    position: absolute;
    left: 65px;
    top: 50%;
    transform: translateY(-50%);
    background: #1f2937;
    color: white;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 13px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.sidebar.collapsed a:hover::after {
    opacity: 1;
}

/* Main content adjustment */
.main-content {
    margin-left: 220px;
    padding: 20px;
    transition: margin-left 0.3s ease;
    min-height: 100vh;
}

.sidebar.collapsed ~ .main-content {
    margin-left: 60px;
}

/* Smooth interactions */
.sidebar a:active {
    transform: translateX(2px) scale(0.99);
}

/* Responsive design */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    
    .sidebar a:hover {
        transform: translateX(0);
        background: rgba(220, 38, 38, 0.2);
    }

    .main-content {
        margin-left: 0;
    }

    .toggle-btn {
        display: none;
    }
}

/* Clean scrollbar */
.sidebar::-webkit-scrollbar {
    width: 4px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #991b1b;
    border-radius: 2px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #b91c1c;
}

/* Professional hover state for sidebar */
.sidebar:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* Subtle animations for menu items */
.sidebar a {
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Icon spacing */
.sidebar a > * {
    vertical-align: middle;
}

/* Professional border radius */
.sidebar {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
</style>
