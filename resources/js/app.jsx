import './bootstrap';
import React from 'react';
import "@radix-ui/themes/styles.css";
import ReactDOM from 'react-dom/client';
import AdminDashboard from './adminDashboard';
import '../css/app.css';

ReactDOM.createRoot(document.getElementById('app')).render(
    <React.StrictMode>
        <AdminDashboard />
    </React.StrictMode>
);