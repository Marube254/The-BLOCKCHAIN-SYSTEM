@extends('filament::components.layouts.app')

@push('styles')
<style>
    /* Light Mode Text Colors - Ensure Visibility */
    .dark\:text-white {
        color: #111827 !important;
    }
    
    .text-gray-500 {
        color: #6b7280 !important;
    }
    
    .text-gray-700 {
        color: #374151 !important;
    }
    
    .text-gray-900 {
        color: #111827 !important;
    }
    
    /* Sidebar Text */
    .fi-sidebar-nav-item-label {
        color: #1f2937 !important;
    }
    
    /* Table Text */
    .fi-ta-text-item {
        color: #1f2937 !important;
    }
    
    /* Heading */
    .fi-header-heading {
        color: #111827 !important;
    }

    /* Custom Filament Admin Theme - Dark Red & White */

    /* Primary Color Override */
    :root {
        --primary-50: #fef2f2;
        --primary-100: #fee2e2;
        --primary-200: #fecaca;
        --primary-300: #fca5a5;
        --primary-400: #f87171;
        --primary-500: #8B0000;
        --primary-600: #7a0000;
        --primary-700: #690000;
        --primary-800: #580000;
        --primary-900: #470000;
    }

    /* Light Mode - Ensure Text Visibility */
    body {
        background-color: #f9fafb;
    }

    /* Card Background - White for Light Mode */
    .fi-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
    }

    /* Active Sidebar Item */
    .fi-sidebar-nav-item-active {
        background-color: #fef2f2 !important;
        color: #8B0000 !important;
    }

    /* Table Headers */
    .fi-ta-header-cell {
        background-color: #fef2f2 !important;
        color: #8B0000 !important;
        font-weight: 600 !important;
    }

    /* Buttons */
    .fi-btn-primary {
        background-color: #8B0000 !important;
    }
    .fi-btn-primary:hover {
        background-color: #6a0000 !important;
    }

    /* Links */
    a {
        color: #8B0000 !important;
    }
    a:hover {
        color: #6a0000 !important;
    }

    /* Widget Cards */
    .fi-widget {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    /* Stats Widget Values */
    .fi-stats-widget-stat-value {
        color: #8B0000 !important;
    }

    /* Modal Background */
    .fi-modal-window {
        background-color: #ffffff;
    }

    /* Dropdown Items */
    .fi-dropdown-item:hover {
        background-color: #fef2f2 !important;
        color: #8B0000 !important;
    }

    /* Pagination */
    .fi-pagination-item-active {
        background-color: #8B0000 !important;
        color: #ffffff !important;
    }

    /* Form Inputs */
    .fi-input {
        border-color: #e5e7eb !important;
    }
    .fi-input:focus {
        border-color: #8B0000 !important;
        ring-color: #8B0000 !important;
    }

    /* Badge Colors */
    .fi-badge-success {
        background-color: #10b981 !important;
    }
    .fi-badge-warning {
        background-color: #f59e0b !important;
    }
    .fi-badge-danger {
        background-color: #dc2626 !important;
    }
</style>
@endpush