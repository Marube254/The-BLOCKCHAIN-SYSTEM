<style>
    :root {
        --dark-red: #8B0000;
        --dark-red-light: #a30000;
        --dark-red-dark: #6a0000;
        --sidebar-bg: #4b5563;
        --border-color: #d1d5db;
        --accent-gray: #6b7280;
    }

    /* Sidebar Styling - Dark Red */
    .fi-sidebar {
        background-color: var(--dark-red) !important;
        border-right: 2px solid var(--dark-red-dark) !important;
    }

    .fi-sidebar-header {
        background-color: var(--dark-red-dark) !important;
        border-bottom: 3px solid var(--dark-red) !important;
        padding: 1.5rem !important;
    }

    .fi-sidebar-header-icon,
    .fi-sidebar-header-text {
        color: white !important;
        font-weight: 700 !important;
    }

    /* Sidebar Navigation Items */
    .fi-sidebar-nav-item {
        color: rgba(255, 255, 255, 0.85) !important;
        border-left: 4px solid transparent !important;
        margin: 0.5rem 0 !important;
        transition: all 0.3s ease !important;
    }

    .fi-sidebar-nav-item:hover {
        background-color: var(--dark-red-light) !important;
        color: white !important;
        border-left-color: white !important;
        padding-left: 1.5rem !important;
    }

    .fi-sidebar-nav-item.fi-sidebar-nav-item-active {
        background-color: #374151 !important; /* Professional grey background */
        color: #1f2937 !important; /* Dark grey text for visibility against any white background */
        border-left-color: #60a5fa !important; /* Blue accent border */
        font-weight: 600 !important;
        box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.3) !important;
        border-radius: 0.375rem !important;
        margin: 0.25rem 0.5rem !important;
    }

    /* Focus state for clicked buttons - ensure text is visible */
    .fi-sidebar-nav-item:focus,
    .fi-sidebar-nav-item:active {
        background-color: #f3f4f6 !important; /* Light grey/white background */
        color: #1f2937 !important; /* Dark text for visibility on light background */
        outline: none !important;
        border-left-color: #3b82f6 !important;
    }

    .fi-sidebar-nav-item-icon {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Ensure all text on red background is white and clear - HIGH PRIORITY */
    .fi-sidebar,
    .fi-sidebar * {
        color: white !important;
    }

    /* Specific sidebar text elements - maximum specificity */
    .fi-sidebar .fi-sidebar-header-text,
    .fi-sidebar .fi-sidebar-nav-item,
    .fi-sidebar .fi-sidebar-nav-item:hover,
    .fi-sidebar .fi-sidebar-nav-item.fi-sidebar-nav-item-active,
    .fi-sidebar .fi-sidebar-nav-group-label,
    .fi-sidebar .fi-sidebar-footer,
    .fi-sidebar .fi-sidebar-logo,
    .fi-sidebar .fi-sidebar-logo-text,
    .fi-sidebar a,
    .fi-sidebar span,
    .fi-sidebar div {
        color: white !important;
    }

    /* Navigation item text specifically */
    .fi-sidebar-nav-item-text {
        color: white !important;
    }

    /* Icon colors in sidebar */
    .fi-sidebar .fi-sidebar-nav-item-icon {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Active state icons */
    .fi-sidebar-nav-item.fi-sidebar-nav-item-active .fi-sidebar-nav-item-icon {
        color: white !important;
    }

    /* Group labels */
    .fi-sidebar-nav-group-label {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Chart Widget Styling - Grey Background */
    .fi-wi-chart {
        background: #f3f4f6 !important;
        border: 2px solid var(--border-color) !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        transition: all 0.3s ease !important;
    }

    .fi-wi-chart:hover {
        border-color: var(--dark-red) !important;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.12) !important;
    }

    .fi-wi-chart .fi-wi-header {
        background: linear-gradient(135deg, #e5e7eb 0%, #f3f4f6 100%) !important;
        border-bottom: 2px solid var(--border-color) !important;
        padding: 1.25rem !important;
        color: var(--dark-red) !important;
        font-weight: 600 !important;
    }

    /* Widget Styling - Borders and Shadows */
    .fi-wi-stats-overview-card,
    .fi-wi-card,
    [class*="widget"] {
        background: white !important;
        border: 2px solid var(--border-color) !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        transition: all 0.3s ease !important;
    }

    .fi-wi-stats-overview-card:hover,
    .fi-wi-card:hover,
    [class*="widget"]:hover {
        border-color: var(--dark-red) !important;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.12) !important;
        transform: translateY(-2px) !important;
    }

    /* Widget Header */
    .fi-widget-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
        border-bottom: 2px solid var(--border-color) !important;
        padding: 1rem !important;
        font-weight: 600 !important;
        color: var(--dark-red) !important;
    }

    /* Page Header/Dashboard Title */
    .fi-page-header {
        background: white !important;
        border-bottom: 2px solid var(--border-color) !important;
        padding: 2rem 0 !important;
    }

    .fi-page-header-heading {
        color: var(--dark-red) !important;
        font-weight: 700 !important;
        font-size: 2rem !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
    }

    .fi-page-header-subheading {
        color: var(--accent-gray) !important;
        font-size: 1rem !important;
    }

    /* Stats Cards Styling - Make numbers even darker */
    .fi-stats-overview-stat {
        background: white !important;
        border-left: 4px solid var(--dark-red) !important;
        padding: 1.5rem !important;
        border-radius: 0.5rem !important;
    }

    .fi-stats-overview-stat-header {
        color: var(--accent-gray) !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .fi-stats-overview-stat-value {
        color: #000000 !important; /* Pure black for maximum visibility */
        font-weight: 700 !important;
        font-size: 1.875rem !important;
        margin-top: 0.5rem !important;
        text-shadow: 0 1px 3px rgba(255, 255, 255, 0.8) !important; /* White shadow for contrast */
    }

    /* Dark theme overrides (no bright white cards) */
    .dark body,
    .dark .fi-body,
    .dark .fi-panel-{{ filament()->getId() }} {
        background-color: #0f172a !important;
        color: #e5e7eb !important;
    }

    .dark .fi-page, .dark .fi-page-content, .dark .fi-page-header,
    .dark .fi-wi-card, .dark .fi-wi-stats-overview-card,
    .dark [class*="widget"], .dark .fi-stats-overview-stat,
    .dark .fi-wi-chart {
        background: #111827 !important;
        border-color: #334155 !important;
        color: #e5e7eb !important;
    }

    .dark .fi-page-header {
        border-bottom-color: #1e293b !important;
    }

    .dark .fi-widget-header {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
        color: #cbd5e1 !important;
    }

    .dark .fi-sidebar-nav-item:focus,
    .dark .fi-sidebar-nav-item:active {
        background-color: #334155 !important;
        color: #f8fafc !important;
        border-left-color: #60a5fa !important;
    }

    .dark .fi-sidebar-nav-item.fi-sidebar-nav-item-active {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border-left-color: #60a5fa !important;
        box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.5) !important;
    }

    .fi-stats-overview-stat-description {
        color: var(--accent-gray) !important;
        font-size: 0.8125rem !important;
        margin-top: 0.5rem !important;
    }

    /* Topbar Styling */
    .fi-topbar {
        background: white !important;
        border-bottom: 2px solid var(--border-color) !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    }

    .fi-topbar-item {
        color: var(--accent-gray) !important;
    }

    .fi-topbar-item:hover {
        color: var(--dark-red) !important;
    }

    /* Table Styling */
    .fi-dataTable-thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #f3f4f6 100%) !important;
        border-bottom: 2px solid var(--border-color) !important;
    }

    .fi-dataTable-th {
        color: var(--dark-red) !important;
        font-weight: 600 !important;
        padding: 1rem !important;
        border-right: 1px solid var(--border-color) !important;
    }

    .fi-dataTable-tbody tr {
        border-bottom: 1px solid var(--border-color) !important;
        transition: background-color 0.2s ease !important;
    }

    .fi-dataTable-tbody tr:hover {
        background-color: #f9fafb !important;
    }

    /* Form Styling */
    .fi-form-field {
        margin-bottom: 1.5rem !important;
    }

    .fi-form-field-label {
        color: var(--dark-red) !important;
        font-weight: 600 !important;
    }

    /* Button Styling */
    button[class*="btn-primary"],
    button[class*="fi-btn-primary"],
    .fi-btn-primary {
        background: linear-gradient(135deg, var(--dark-red) 0%, var(--dark-red-dark) 100%) !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(139, 0, 0, 0.3) !important;
        transition: all 0.3s ease !important;
    }

    button[class*="btn-primary"]:hover,
    button[class*="fi-btn-primary"]:hover,
    .fi-btn-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.4) !important;
    }

    /* Badge Styling */
    .fi-badge-primary {
        background-color: rgba(139, 0, 0, 0.1) !important;
        color: var(--dark-red) !important;
        border: 1px solid var(--dark-red) !important;
    }

    /* Page Container */
    .fi-page {
        background: #f8f9fa !important;
    }

    /* Navigation Group Label */
    .fi-sidebar-nav-group-label {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 0.75rem 1rem !important;
    }

    /* Sidebar Footer */
    .fi-sidebar-footer {
        background-color: var(--dark-red-dark) !important;
        border-top: 2px solid var(--dark-red) !important;
    }

    .fi-sidebar-footer * {
        color: white !important;
    }

    .fi-sidebar-logo {
        color: white !important;
    }

    .fi-sidebar-logo-text {
        color: white !important;
        font-weight: 700 !important;
    }

    /* Success Messages */
    .fi-notification.fi-notification-success {
        background-color: rgba(16, 185, 129, 0.1) !important;
        border-left: 4px solid #10b981 !important;
        color: #065f46 !important;
    }

    /* Error Messages */
    .fi-notification.fi-notification-danger {
        background-color: rgba(220, 38, 38, 0.1) !important;
        border-left: 4px solid #dc2626 !important;
        color: #7f1d1d !important;
    }

    /* Warning Messages */
    .fi-notification.fi-notification-warning {
        background-color: rgba(245, 158, 11, 0.1) !important;
        border-left: 4px solid #f59e0b !important;
        color: #78350f !important;
    }
</style>
