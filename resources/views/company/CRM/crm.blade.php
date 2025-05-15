@extends('layouts.vertical', ['page_title' => 'CRM Dashboard'])

@section('css')
@vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'])
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Tab Navigation */
    #crmTabs {
        border-bottom: 1px solid var(--ct-border-color);
        margin-bottom: 1.5rem;
    }

    #crmTabs .nav-link {
        color: var(--ct-body-color);
        padding: 0.75rem 1.25rem;
        border-radius: 0;
        position: relative;
    }

    #crmTabs .nav-link:after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--ct-primary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    #crmTabs .nav-link.active {
        color: var(--ct-primary);
        background: transparent;
        border: none;
    }

    #crmTabs .nav-link.active:after {
        transform: scaleX(1);
    }

    #crmTabs .nav-link:hover {
        border-color: transparent;
    }

    /* Tab Content */
    .tab-content {
        padding: 1.5rem 0;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    /* Card Styling */
    .card {
        border: none;
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.25);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid var(--ct-border-color);
        padding: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Stats Cards */
    .stats-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 16px;
        background: linear-gradient(45deg, var(--ct-primary), var(--ct-primary-dark));
        margin-bottom: 1.5rem;
    }

    .stats-card .stats-icon {
        position: absolute;
        right: -15px;
        bottom: -15px;
        font-size: 4rem;
        opacity: 0.1;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1);
        opacity: 0.2;
    }

    .stats-card .stats-title {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stats-card .stats-value {
        color: var(--ct-white);
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .stats-card .stats-change {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Opportunity Stats Cards */
    .stat-card {
        background: var(--ct-white);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: var(--ct-primary);
    }

    .stat-title {
        color: var(--ct-gray-600);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--ct-gray-900);
        margin-bottom: 0.5rem;
    }

    .stat-change {
        font-size: 0.813rem;
        color: var(--ct-gray-600);
    }

    .stat-change i {
        margin-right: 0.25rem;
    }

    /* Dark mode adjustments */
    [data-bs-theme="dark"] .stat-card {
        background: var(--ct-gray-800);
    }

    [data-bs-theme="dark"] .stat-value {
        color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .stat-title,
    [data-bs-theme="dark"] .stat-change {
        color: var(--ct-gray-400);
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
    }

    .table> :not(:first-child) {
        border-top: none;
    }

    .table th {
        font-weight: 600;
        background-color: var(--ct-gray-100);
    }

    .table td {
        vertical-align: middle;
    }

    /* Form Styling */
    .form-floating {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-floating>.form-control,
    .form-floating>.form-select {
        height: calc(3.5rem + 2px);
        padding: 1rem 0.75rem;
    }

    .form-floating>label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 0.75rem;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity .1s ease-in-out, transform .1s ease-in-out;
    }

    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label,
    .form-floating>.form-select~label {
        opacity: .65;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* Progress Bar */
    .progress {
        background-color: var(--ct-gray-200);
        border-radius: 0.5rem;
        height: 0.5rem;
    }

    .progress-bar {
        border-radius: 0.5rem;
    }

    /* Badges */
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }

    /* Avatar */
    .avatar-sm {
        height: 2.25rem;
        width: 2.25rem;
    }

    .avatar-title {
        align-items: center;
        display: flex;
        font-weight: 500;
        height: 100%;
        justify-content: center;
        width: 100%;
    }

    /* Chart Styles */
    .chart-widget-list {
        margin-top: 1rem;
    }

    .chart-widget-list p {
        border-bottom: 1px solid var(--ct-border-color);
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid var(--ct-border-color);
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--ct-border-color);
        padding: 1.5rem;
    }

    /* Dark Mode Styles */
    [data-bs-theme="dark"] .card {
        background-color: var(--ct-gray-800);
        box-shadow: 0 0 35px 0 rgba(0, 0, 0, 0.25);
    }

    [data-bs-theme="dark"] .table th {
        background-color: var(--ct-gray-700);
    }

    [data-bs-theme="dark"] .progress {
        background-color: var(--ct-gray-700);
    }

    [data-bs-theme="dark"] .modal-content {
        background-color: var(--ct-gray-800);
        box-shadow: 0 0 35px 0 rgba(0, 0, 0, 0.25);
    }

    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .form-select {
        background-color: var(--ct-gray-700);
        border-color: var(--ct-gray-600);
        color: var(--ct-gray-200);
    }

    [data-bs-theme="dark"] .form-control:focus,
    [data-bs-theme="dark"] .form-select:focus {
        background-color: var(--ct-gray-700);
        border-color: var(--ct-primary);
        box-shadow: 0 0 0 0.15rem rgba(114, 124, 245, 0.25);
    }

    [data-bs-theme="dark"] .form-floating>label {
        color: var(--ct-gray-400);
    }

    [data-bs-theme="dark"] .chart-widget-list p {
        border-color: var(--ct-gray-700);
    }

    /* Animation Effects */
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
    }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: var(--ct-gray-200);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--ct-gray-400);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--ct-gray-500);
    }

    [data-bs-theme="dark"] ::-webkit-scrollbar-track {
        background: var(--ct-gray-700);
    }

    [data-bs-theme="dark"] ::-webkit-scrollbar-thumb {
        background: var(--ct-gray-600);
    }

    [data-bs-theme="dark"] ::-webkit-scrollbar-thumb:hover {
        background: var(--ct-gray-500);
    }

    /* Button Styles */
    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        box-shadow: 0 2px 6px rgba(114, 124, 245, 0.25);
    }

    .btn-success {
        box-shadow: 0 2px 6px rgba(10, 207, 151, 0.25);
    }

    .btn-warning {
        box-shadow: 0 2px 6px rgba(255, 195, 90, 0.25);
    }

    .btn-danger {
        box-shadow: 0 2px 6px rgba(250, 92, 124, 0.25);
    }

    /* Input Group Styling */
    .input-group {
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .input-group-text {
        background-color: var(--ct-gray-100);
        border: 1px solid var(--ct-border-color);
    }

    [data-bs-theme="dark"] .input-group-text {
        background-color: var(--ct-gray-700);
        border-color: var(--ct-gray-600);
        color: var(--ct-gray-200);
    }

    /* Dropdown Styling */
    .dropdown-menu {
        border: none;
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        border-radius: 0.375rem;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1.5rem;
        font-weight: 400;
        transition: all 0.2s ease-in-out;
    }

    .dropdown-item:hover {
        background-color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .dropdown-menu {
        background-color: var(--ct-gray-800);
        box-shadow: 0 0 35px 0 rgba(0, 0, 0, 0.25);
    }

    [data-bs-theme="dark"] .dropdown-item {
        color: var(--ct-gray-200);
    }

    [data-bs-theme="dark"] .dropdown-item:hover {
        background-color: var(--ct-gray-700);
        color: var(--ct-gray-100);
    }
</style>
<style>
    /* Enhanced Dashboard Cards */
    .dashboard-card {
        background: var(--ct-white);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .dashboard-card .card-body {
        padding: 1.5rem;
    }

    .stat-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 16px;
        background: linear-gradient(45deg, var(--ct-primary), var(--ct-primary-dark));
        margin-bottom: 1.5rem;
    }

    .stat-card .stat-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        opacity: 0.1;
        color: var(--ct-white);
    }

    .stat-card .stat-title {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stat-card .stat-value {
        color: var(--ct-white);
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .stat-card .stat-change {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Marketing Section */
    .marketing-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .marketing-card {
        background: var(--ct-white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .marketing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .marketing-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .marketing-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: var(--ct-primary);
        color: var(--ct-white);
    }

    /* Accounts Section */
    .account-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .account-card {
        background: var(--ct-white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .account-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .account-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .account-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--ct-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ct-white);
        font-size: 1.5rem;
    }

    /* Dark Mode */
    [data-bs-theme="dark"] .dashboard-card,
    [data-bs-theme="dark"] .marketing-card,
    [data-bs-theme="dark"] .account-card {
        background: var(--ct-gray-800);
    }

    [data-bs-theme="dark"] .stat-card {
        background: linear-gradient(45deg, var(--ct-primary-dark), var(--ct-primary));
    }
</style>
<style>
    /* Enhanced Sales Cards */
    .stat-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Total Sales Card */
    .stat-card.sales {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        box-shadow: 0 8px 24px -4px rgba(99, 102, 241, 0.25);
    }

    /* Conversion Rate Card */
    .stat-card.conversion {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 8px 24px -4px rgba(16, 185, 129, 0.25);
    }

    /* Deal Size Card */
    .stat-card.deal {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 8px 24px -4px rgba(245, 158, 11, 0.25);
    }

    /* Pipeline Card */
    .stat-card.pipeline {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 8px 24px -4px rgba(59, 130, 246, 0.25);
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card .stat-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3.5rem;
        opacity: 0.15;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.2;
    }

    .stat-card .stat-title {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-value {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card .stat-change {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .stat-card .stat-change i {
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Dark Mode Adjustments */
    [data-bs-theme="dark"] .stat-card.sales {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    }

    [data-bs-theme="dark"] .stat-card.conversion {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    [data-bs-theme="dark"] .stat-card.deal {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    [data-bs-theme="dark"] .stat-card.pipeline {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }
</style>
<style>
    /* Support Tab Styles */
    .kb-card {
        padding: 1.5rem;
        border-radius: 0.5rem;
        background-color: var(--ct-card-bg);
        border: 1px solid var(--ct-border-color);
        text-align: center;
        transition: all 0.3s;
    }

    .kb-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .kb-card-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 1.5rem;
    }

    /* Chat Popup Styles */
    .chat-popup {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 350px;
        height: 500px;
        background-color: var(--ct-card-bg);
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .chat-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    @keyframes slideIn {
        from {
            transform: translateY(100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .chat-popup-header {
        padding: 1rem;
        border-bottom: 1px solid var(--ct-border-color);
        background-color: var(--ct-card-bg);
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .chat-popup-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background-color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .chat-popup-messages {
        background-color: var(--ct-gray-800);
    }

    .chat-popup-input {
        padding: 1rem;
        border-top: 1px solid var(--ct-border-color);
        background-color: var(--ct-card-bg);
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .message {
        display: flex;
        margin-bottom: 1rem;
    }

    .message.received {
        justify-content: flex-start;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message-content {
        max-width: 80%;
    }

    .message-text {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        margin-bottom: 0.25rem;
    }

    .message.received .message-text {
        background-color: var(--ct-card-bg);
        border: 1px solid var(--ct-border-color);
        border-bottom-left-radius: 0.25rem;
    }

    .message.sent .message-text {
        background-color: var(--ct-primary);
        color: #fff;
        border-bottom-right-radius: 0.25rem;
    }

    .chat-user-avatar {
        position: relative;
    }

    .user-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* Responsive Styles */
    @media (max-width: 576px) {
        .chat-popup {
            bottom: 0;
            right: 0;
            width: 100%;
            height: calc(100vh - 60px);
            max-width: none;
            border-radius: 15px 15px 0 0;
        }

        .chat-popup-header {
            border-radius: 15px 15px 0 0;
        }

        .kb-card {
            margin-bottom: 1rem;
        }
    }

    /* DataTable Customization */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--ct-primary) !important;
        border-color: var(--ct-primary) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--ct-primary-rgb) !important;
        border-color: var(--ct-primary) !important;
        color: #fff !important;
    }

    /* Badge Customization */
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
<style>
    /* Live Chat Button Styles */
    .chat-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1049;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .chat-button i {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .chat-button:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .chat-button:hover i {
        transform: scale(1.1);
    }

    /* Enhanced Chat Popup Styles */
    .chat-popup {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 350px;
        height: 500px;
        background-color: var(--ct-card-bg);
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        display: none;
        flex-direction: column;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .chat-popup.show {
        display: flex;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .chat-popup-messages {
        flex: 1;
        overflow-y: auto;
    }

    .message {
        max-width: 80%;
        margin-bottom: 1rem;
    }

    .message.sent {
        margin-left: auto;
    }

    .message.received {
        margin-right: auto;
    }

    .message-content {
        display: inline-block;
    }

    .message.sent .message-text {
        background-color: var(--ct-primary);
        color: white;
    }

    .message.received .message-text {
        background-color: var(--ct-light);
        color: var(--ct-dark);
    }

    .message-text {
        border-radius: 15px;
        padding: 8px 12px;
        max-width: 100%;
        word-wrap: break-word;
    }

    .user-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid white;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .chat-button {
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
        }

        .chat-button i {
            font-size: 1.25rem;
        }

        .chat-popup {
            bottom: 80px;
            right: 10px;
            width: calc(100% - 20px);
            max-width: 350px;
            height: 60vh;
        }
    }

    @media (max-width: 576px) {
        .chat-popup {
            bottom: 0;
            right: 0;
            width: 100%;
            height: calc(100vh - 60px);
            max-width: none;
            border-radius: 15px 15px 0 0;
        }

        .chat-popup-header {
            border-radius: 15px 15px 0 0;
        }

        .chat-button {
            bottom: 15px;
            right: 15px;
            width: 45px;
            height: 45px;
        }

        .chat-button i {
            font-size: 1.1rem;
        }
    }

    /* Dark mode adjustments */
    [data-bs-theme="dark"] .chat-button {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    [data-bs-theme="dark"] .chat-popup {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    }

    [data-bs-theme="dark"] .message.received .message-text {
        background-color: var(--ct-gray-700);
        color: var(--ct-light);
    }
</style>
<style>
    /* Activity Section Styles */
    .activity-calendar {
        background: var(--ct-white);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .activity-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--ct-gray-900);
    }

    .activity-nav {
        display: flex;
        gap: 8px;
    }

    .activity-nav-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ct-gray-100);
        border: none;
        color: var(--ct-gray-700);
        transition: all 0.2s ease;
    }

    .activity-nav-btn:hover {
        background: var(--ct-gray-200);
        color: var(--ct-gray-900);
    }

    /* Quick Actions */
    .quick-actions {
        background: var(--ct-white);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .quick-actions-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--ct-gray-900);
        margin-bottom: 16px;
    }

    .quick-action-btn {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        margin-bottom: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .quick-action-btn i {
        font-size: 1.1rem;
    }

    .btn-new-task {
        background: var(--ct-primary);
        color: white;
    }

    .btn-new-task:hover {
        background: #0d6efd;
        transform: translateY(-1px);
    }

    .btn-schedule-call {
        background: #0099ff;
        color: white;
    }

    .btn-schedule-call:hover {
        background: #0088ee;
        transform: translateY(-1px);
    }

    .btn-schedule-meeting {
        background: #34c38f;
        color: white;
    }

    .btn-schedule-meeting:hover {
        background: #2fb380;
        transform: translateY(-1px);
    }

    .btn-add-note {
        background: #f1b44c;
        color: white;
    }

    .btn-add-note:hover {
        background: #e1a73e;
        transform: translateY(-1px);
    }

    /* Recent Activities */
    .recent-activities {
        background: var(--ct-white);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .activities-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .activity-filter {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid var(--ct-gray-200);
        background: var(--ct-white);
        color: var(--ct-gray-700);
        font-size: 0.9rem;
    }

    .activity-item {
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        background: var(--ct-gray-50);
        transition: all 0.2s ease;
    }

    .activity-item:hover {
        background: var(--ct-gray-100);
        transform: translateX(2px);
    }

    .activity-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .activity-item-title {
        font-weight: 500;
        color: var(--ct-gray-900);
    }

    .activity-item-time {
        font-size: 0.85rem;
        color: var(--ct-gray-600);
    }

    .activity-item-subtitle {
        font-size: 0.9rem;
        color: var(--ct-gray-600);
    }

    .activity-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-task {
        background: rgba(114, 124, 245, 0.1);
        color: var(--ct-primary);
    }

    .badge-call {
        background: rgba(0, 153, 255, 0.1);
        color: #0099ff;
    }

    .badge-meeting {
        background: rgba(52, 195, 143, 0.1);
        color: #34c38f;
    }

    /* Dark Mode Styles */
    [data-bs-theme="dark"] .activity-calendar,
    [data-bs-theme="dark"] .quick-actions,
    [data-bs-theme="dark"] .recent-activities {
        background: var(--ct-gray-800);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    [data-bs-theme="dark"] .activity-title,
    [data-bs-theme="dark"] .quick-actions-title {
        color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .activity-nav-btn {
        background: var(--ct-gray-700);
        color: var(--ct-gray-300);
    }

    [data-bs-theme="dark"] .activity-nav-btn:hover {
        background: var(--ct-gray-600);
        color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .activity-item {
        background: var(--ct-gray-700);
    }

    [data-bs-theme="dark"] .activity-item:hover {
        background: var(--ct-gray-600);
    }

    [data-bs-theme="dark"] .activity-item-title {
        color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .activity-item-subtitle,
    [data-bs-theme="dark"] .activity-item-time {
        color: var(--ct-gray-400);
    }

    [data-bs-theme="dark"] .activity-filter {
        background: var(--ct-gray-700);
        border-color: var(--ct-gray-600);
        color: var(--ct-gray-300);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {

        .activity-calendar,
        .quick-actions,
        .recent-activities {
            padding: 15px;
        }

        .quick-action-btn {
            padding: 10px;
        }

        .activity-item {
            padding: 12px;
        }
    }
</style>
<style>
    /* Sales Metrics Cards */
    .metrics-card {
        background: var(--ct-white);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .metrics-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .metrics-title {
        color: var(--ct-gray-600);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .metrics-value {
        font-size: 2rem;
        font-weight: 600;
        color: var(--ct-gray-900);
        margin-bottom: 8px;
        line-height: 1.2;
        position: relative;
        z-index: 1;
    }

    .metrics-trend {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
        position: relative;
        z-index: 1;
    }

    .metrics-trend.positive {
        color: #34c38f;
    }

    .metrics-trend.negative {
        color: #fa5c7c;
    }

    .metrics-trend i {
        font-size: 1rem;
    }

    .metrics-period {
        color: var(--ct-gray-500);
        font-size: 0.75rem;
        margin-left: 4px;
    }

    .metrics-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.1;
        transform: rotate(-15deg);
        transition: all 0.3s ease;
    }

    .metrics-card:hover .metrics-icon {
        transform: rotate(0deg) scale(1.1);
        opacity: 0.15;
    }

    /* Dark Mode Styles */
    [data-bs-theme="dark"] .metrics-card {
        background: var(--ct-gray-800);
    }

    [data-bs-theme="dark"] .metrics-title {
        color: var(--ct-gray-400);
    }

    [data-bs-theme="dark"] .metrics-value {
        color: var(--ct-gray-100);
    }

    [data-bs-theme="dark"] .metrics-period {
        color: var(--ct-gray-500);
    }

    /* Navigation Buttons */
    .metrics-nav {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
    }

    .metrics-nav-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ct-gray-100);
        border: none;
        color: var(--ct-gray-700);
        transition: all 0.2s ease;
    }

    .metrics-nav-btn:hover {
        background: var(--ct-gray-200);
        color: var(--ct-gray-900);
    }

    [data-bs-theme="dark"] .metrics-nav-btn {
        background: var(--ct-gray-700);
        color: var(--ct-gray-300);
    }

    [data-bs-theme="dark"] .metrics-nav-btn:hover {
        background: var(--ct-gray-600);
        color: var(--ct-gray-100);
    }
</style>
<style>
    /* Marketing Section Styles */
    .marketing-stat-card {
        background: var(--ct-white);
        border-radius: 0.5rem;
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.2s;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .marketing-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .marketing-stat {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        background: var(--ct-light);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .marketing-stat h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--ct-primary);
    }

    .marketing-stat p {
        margin-bottom: 0;
        color: var(--ct-secondary);
        font-size: 0.875rem;
    }

    .chart-container {
        position: relative;
        height: 250px;
        margin: 1rem 0;
    }

    .campaign-progress {
        height: 6px;
        margin-top: 0.5rem;
        background-color: rgba(0, 0, 0, 0.05);
    }

    [data-bs-theme="dark"] .marketing-stat-card {
        background: var(--ct-dark);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .marketing-stat {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .campaign-progress {
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>
<style>
    /* New Deal Button & Modal Styles */
    .new-deal-btn {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .new-deal-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
    }

    .new-deal-btn i {
        transition: transform 0.3s ease;
    }

    .new-deal-btn:hover i {
        transform: rotate(45deg);
    }

    .modal-custom {
        padding: 1rem;
    }

    .modal-custom .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .modal-custom .modal-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        padding: 1.5rem;
        border: none;
    }

    .modal-custom .modal-title {
        color: #fff;
        font-weight: 600;
    }

    .modal-custom .modal-header .btn-close {
        color: #fff;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .modal-custom .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-custom .modal-body {
        padding: 2rem;
    }

    .modal-custom .form-label {
        font-weight: 500;
        color: var(--ct-gray-700);
        margin-bottom: 0.5rem;
    }

    .modal-custom .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--ct-gray-200);
        transition: all 0.2s ease;
    }

    .modal-custom .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .modal-custom .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--ct-gray-200);
        transition: all 0.2s ease;
    }

    .modal-custom .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .modal-custom .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--ct-gray-200);
        background: var(--ct-gray-50);
    }

    .btn-modal-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-modal-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }

    /* Dark Mode */
    [data-bs-theme="dark"] .modal-custom .modal-content {
        background: var(--ct-gray-800);
    }

    [data-bs-theme="dark"] .modal-custom .form-label {
        color: var(--ct-gray-300);
    }

    [data-bs-theme="dark"] .modal-custom .form-control,
    [data-bs-theme="dark"] .modal-custom .form-select {
        background: var(--ct-gray-700);
        border-color: var(--ct-gray-600);
        color: var(--ct-gray-200);
    }

    [data-bs-theme="dark"] .modal-custom .modal-footer {
        background: var(--ct-gray-900);
        border-color: var(--ct-gray-700);
    }
</style>
<style>
    /* Marketing Section Styles */
    .marketing-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .marketing-card,
    .campaign-card {
        background: var(--ct-white);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .marketing-card:hover,
    .campaign-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    /* Marketing Stats */
    .marketing-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
        padding: 1.5rem;
    }

    .marketing-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: var(--ct-primary);
        color: var(--ct-white);
        transition: transform 0.3s ease;
    }

    .marketing-card:hover .marketing-icon {
        transform: scale(1.1);
    }

    /* Typography */
    .marketing-stat h6,
    .campaign-metric p {
        font-size: 0.875rem;
        color: var(--ct-gray-600);
        margin-bottom: 0.25rem;
    }

    .marketing-stat h3,
    .campaign-metric h4 {
        color: var(--ct-gray-900);
        font-weight: 600;
        margin-bottom: 0;
    }

    .marketing-stat h3 {
        font-size: 1.5rem;
    }

    .campaign-metric h4 {
        font-size: 1.25rem;
    }

    /* Progress Bars */
    .progress {
        background-color: var(--ct-gray-100);
        border-radius: 6px;
        overflow: hidden;
        height: 8px;
    }

    .progress-bar {
        transition: width 1s ease;
        border-radius: 6px;
    }

    /* Campaign Section */
    .campaign-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--ct-gray-200);
    }

    .campaign-body {
        padding: 1.5rem;
    }

    .campaign-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .campaign-metric {
        text-align: center;
        padding: 1rem;
        background: var(--ct-gray-50);
        border-radius: 12px;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] {

        .marketing-card,
        .campaign-card {
            background: var(--ct-gray-800);
        }

        .marketing-stat h6,
        .campaign-metric p {
            color: var(--ct-gray-400);
        }

        .marketing-stat h3,
        .campaign-metric h4 {
            color: var(--ct-gray-100);
        }

        .progress {
            background-color: var(--ct-gray-700);
        }

        .campaign-header {
            border-color: var(--ct-gray-700);
        }

        .campaign-metric {
            background: var(--ct-gray-900);
        }
    }
</style>
<style>
    /* New Deal Button & Modal Styles */
    .new-deal-btn {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .new-deal-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
    }

    .new-deal-btn i {
        transition: transform 0.3s ease;
    }

    .new-deal-btn:hover i {
        transform: rotate(45deg);
    }

    .modal-custom {
        padding: 1rem;
    }

    .modal-custom .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .modal-custom .modal-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        padding: 1.5rem;
        border: none;
    }

    .modal-custom .modal-title {
        color: #fff;
        font-weight: 600;
    }

    .modal-custom .modal-header .btn-close {
        color: #fff;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .modal-custom .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-custom .modal-body {
        padding: 2rem;
    }

    .modal-custom .form-label {
        font-weight: 500;
        color: var(--ct-gray-700);
        margin-bottom: 0.5rem;
    }

    .modal-custom .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--ct-gray-200);
        transition: all 0.2s ease;
    }

    .modal-custom .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .modal-custom .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--ct-gray-200);
        transition: all 0.2s ease;
    }

    .modal-custom .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .modal-custom .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--ct-gray-200);
        background: var(--ct-gray-50);
    }

    .btn-modal-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-modal-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }

    /* Dark Mode */
    [data-bs-theme="dark"] .modal-custom .modal-content {
        background: var(--ct-gray-800);
    }

    [data-bs-theme="dark"] .modal-custom .form-label {
        color: var(--ct-gray-300);
    }

    [data-bs-theme="dark"] .modal-custom .form-control,
    [data-bs-theme="dark"] .modal-custom .form-select {
        background: var(--ct-gray-700);
        border-color: var(--ct-gray-600);
        color: var(--ct-gray-200);
    }

    [data-bs-theme="dark"] .modal-custom .modal-footer {
        background: var(--ct-gray-900);
        border-color: var(--ct-gray-700);
    }
</style>
<style>
    /* Email Tab Styles */
    .mail-list a {
        display: block;
        padding: 8px 0;
        color: var(--ct-body-color);
        text-decoration: none;
        transition: all 0.2s;
    }

    .mail-list a:hover,
    .mail-list a.active {
        color: var(--ct-primary);
        padding-left: 5px;
    }

    .mail-list a i {
        width: 20px;
    }

    .table-email {
        margin-bottom: 0;
    }

    .table-email tr {
        cursor: pointer;
    }

    .table-email tr:hover {
        background-color: var(--ct-light);
    }

    .table-email tr.unread {
        font-weight: 600;
        background-color: rgba(var(--ct-primary-rgb), 0.05);
    }

    .table-email td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .table-email .email-checkbox,
    .table-email .email-star,
    .table-email .email-attachment,
    .table-email .email-time {
        width: 50px;
    }

    .table-email .email-sender {
        width: 180px;
    }

    .table-email a {
        color: var(--ct-body-color);
        text-decoration: none;
    }

    .table-email a:hover {
        color: var(--ct-primary);
    }

    .attachment-item {
        padding: 8px;
        background-color: var(--ct-light);
        border-radius: 4px;
    }

    .font-10 {
        font-size: 10px;
    }
</style>
@endsection

@section('content')
    <!-- Navigation Pills -->
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="crmTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'customer' ? 'active' : '' }}" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer-tab-pane" type="button" role="tab" aria-controls="customer-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'customer' ? 'true' : 'false' }}">
                    <i class="fas fa-users me-1"></i>Customers  
                </button>
            </li>
            <!-- Leads Tab -->
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ (!isset($activeTab) || $activeTab == 'leads') ? 'active' : '' }}" id="leads-tab" data-bs-toggle="tab" data-bs-target="#leads-tab-pane" type="button" role="tab" aria-controls="leads-tab-pane" aria-selected="{{ (!isset($activeTab) || $activeTab == 'leads') ? 'true' : 'false' }}">
                    <i class="fas fa-user me-1"></i>Leads
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'opportunities' ? 'active' : '' }}" id="opportunity-tab" data-bs-toggle="tab" data-bs-target="#opportunity-tab-pane" type="button" role="tab" aria-controls="opportunity-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'opportunities' ? 'true' : 'false' }}">
                    <i class="fas fa-chart-line me-1"></i>Opportunities
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'email' ? 'active' : '' }}" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane" type="button" role="tab" aria-controls="email-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'email' ? 'true' : 'false' }}">
                    <i class="fas fa-envelope me-1"></i>Email
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'activities' ? 'active' : '' }}" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities-tab-pane" type="button" role="tab" aria-controls="activities-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'activities' ? 'true' : 'false' }}">
                    <i class="fas fa-calendar-check me-1"></i>Activities
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'sales' ? 'active' : '' }}" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales-tab-pane" type="button" role="tab" aria-controls="sales-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'sales' ? 'true' : 'false' }}">
                    <i class="fas fa-chart-line me-1"></i>Sales
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($activeTab) && $activeTab == 'marketing' ? 'active' : '' }}" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="{{ isset($activeTab) && $activeTab == 'marketing' ? 'true' : 'false' }}">
                    <i class="fas fa-bullhorn me-1"></i>Marketing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="support-tab" data-bs-toggle="tab" data-bs-target="#support-tab-pane" type="button" role="tab" aria-controls="support-tab-pane" aria-selected="false">
                    <i class="fas fa-headset me-1"></i>Support
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="crmTabsContent">
            <!-- Customer Tab -->
            <div class="tab-pane fade {{ isset($activeTab) && $activeTab == 'customer' ? 'show active' : '' }}" id="customer-tab-pane" role="tabpanel" aria-labelledby="customer-tab" tabindex="0">
                @php
                    $customerManagement = new \App\Http\Controllers\CRM\CustomerManagment();
                    $dashboardStats = $customerManagement->getDashboardStats();
                @endphp
                @include('company.CRM.crm-customer', ['customers' => $customers ?? \App\Models\Customer::where('company_id', session('selected_company_id'))->orderBy('created_at', 'desc')->get()])
            </div>

            <!-- Leads Tab -->
            <div class="tab-pane fade {{ (!isset($activeTab) || $activeTab == 'leads') ? 'show active' : '' }}" id="leads-tab-pane" role="tabpanel" aria-labelledby="leads-tab" tabindex="0">
                @include('company.CRM.crm-leads', ['leads' => \App\Models\CrmLeads::where('company_id', session('selected_company_id'))->orderBy('created_at', 'desc')->get()])
            </div>

            <!-- Opportunities Tab -->
            <div class="tab-pane fade {{ isset($activeTab) && $activeTab == 'opportunities' ? 'show active' : '' }}" id="opportunity-tab-pane" role="tabpanel" aria-labelledby="opportunity-tab" tabindex="0">
                @php
                    $opportunities = \App\Models\Opportunity::where('company_id', session('selected_company_id'))->orderBy('created_at', 'desc')->get();
                    $openOpportunities = $opportunities->whereNotIn('stage', ['Closed Won', 'Closed Lost']);
                    
                    // Calculate win rate
                    $closedOpportunities = $opportunities->whereIn('stage', ['Closed Won', 'Closed Lost'])->count();
                    $wonOpportunities = $opportunities->where('stage', 'Closed Won')->count();
                    $winRate = $closedOpportunities > 0 ? round(($wonOpportunities / $closedOpportunities) * 100, 1) : 0;
                    
                    // Calculate average deal size
                    $totalAmount = $opportunities->sum('amount');
                    $totalCount = $opportunities->count();
                    $avgDealSize = $totalCount > 0 ? round($totalAmount / $totalCount, 2) : 0;
                    
                    $opportunityStats = [
                        'total_value' => $totalAmount,
                        'open_opportunities' => $openOpportunities->count(),
                        'open_opportunities_percentage' => $totalCount > 0 
                            ? round(($openOpportunities->count() / $totalCount) * 100, 1) 
                            : 0,
                        'win_rate' => $winRate,
                        'avg_deal_size' => $avgDealSize
                    ];
                @endphp
                @include('company.CRM.opportunity', ['opportunities' => $opportunities, 'opportunityStats' => $opportunityStats])
            </div>

            <!-- Email Tab -->
            <div class="tab-pane fade {{ isset($activeTab) && $activeTab == 'email' ? 'show active' : '' }}" id="email-tab-pane" role="tabpanel" aria-labelledby="email-tab" tabindex="0">
                @include('company.CRM.crm-email')
            </div>


            <!-- Activities Tab -->
            <div class="tab-pane fade {{ isset($activeTab) && $activeTab == 'activities' ? 'show active' : '' }}" id="activities-tab-pane" role="tabpanel" aria-labelledby="activities-tab" tabindex="0">
                @php
                    $activities = \App\Models\Activity::where('company_id', session('selected_company_id'))
                        ->with(['relatedModel'])
                        ->orderBy('start_date', 'desc')
                        ->get();
                @endphp
                @include('company.CRM.crm-activity', ['activities' => $activities])
            </div>


            <!-- Sales Tab -->
            <div class="tab-pane fade" id="sales-tab-pane" role="tabpanel" aria-labelledby="sales-tab" tabindex="0">
                @include('company.CRM.sales', ['sales' => \App\Models\crm_sales::where('company_id', session('selected_company_id'))->orderBy('created_at', 'desc')->get()])
            </div>


            <!-- Marketing Tab -->
            <div class="tab-pane fade {{ isset($activeTab) && $activeTab == 'marketing' ? 'show active' : '' }}" 
                id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                @include('company.CRM.marketing', [
                    'campaigns' => \App\Models\Campaign::with('campaignDetails') // Eager load campaignDetails
                        ->where('company_id', session('selected_company_id'))
                        ->latest()
                        ->paginate()
                ])
            </div>
            
            <!-- Support Tab -->
            <div class="tab-pane fade" id="support-tab-pane" role="tabpanel" aria-labelledby="support-tab" tabindex="0">
                @include('company.CRM.support')
            </div>
        </div>

        <!-- The is suppose to be a close  div tag here -->
    
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize tabs with sessionStorage
        var activeTabId = sessionStorage.getItem('crmActiveTab') || '#leads-tab-pane';
        
        // Show active tab on page load
        $('.nav-tabs a[data-bs-target="' + activeTabId + '"]').tab('show');
        
        // Update sessionStorage when tab changes
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            var targetTab = $(e.target).attr('data-bs-target');
            sessionStorage.setItem('crmActiveTab', targetTab);
        });
        
        // Handle direct tab activation
        $('.nav-tabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // Override server-side active state if we have a saved tab
        if (activeTabId) {
            $('.tab-pane').removeClass('show active');
            $(activeTabId).addClass('show active');
            $('.nav-link').removeClass('active');
            $('.nav-tabs a[data-bs-target="' + activeTabId + '"]').addClass('active');
        }
    });
</script>
@endpush