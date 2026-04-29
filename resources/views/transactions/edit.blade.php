<x-app-layout header="Edit Transaction">
    <x-slot:actions><a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    
    <div class="form-container">
        <div class="form-card">
    
            border-bottom: 1px solid #eeeeee;
        }
        .form-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #000;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .form-header p {
            color: #808080;
            font-size: 0.9rem;
        }
        .form-section {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #000;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }
        .form-label.required::after {
            content: ' *';
            color: #000;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cccccc;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #000;
            box-shadow: none;
        }
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-error {
            color: #000;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            font-weight: 600;
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eeeeee;
        }
        .btn-lg {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.95rem !important;
        }
        
        .form-sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }
        .summary-card {
            background: #fff;
            border: 1px solid #000;
            color: #000;
            padding: 1.5rem;
            box-shadow: none;
        }
        .summary-card h3 {
            font-size: 1rem;
            margin-bottom: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .summary-item span {
            color: #808080;
            font-weight: 500;
        }
        .summary-item strong {
            font-weight: 700;
        }
        .summary-divider {
            height: 1px;
            background: #eeeeee;
            margin: 1rem 0;
        }
        @media (max-width: 768px) {
            .form-container {
                grid-template-columns: 1fr;
            }
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function updateWatchInfo() {
            const select = document.getElementById('watch_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.dataset.price || 0;
        }
        updateWatchInfo();
    </script>
</x-app-layout>