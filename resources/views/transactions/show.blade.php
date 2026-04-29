<x-app-layout header="Transaction Details">
    <x-slot name="actions">
        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>

    <div class="detail-container">
        <div class="detail-main">
            <div class="detail-card">
                <!-- Header -->
                <div class="detail-header">
                    <div>
                        <h2 class="invoice-number">{{ $transaction->invoice_number }}</h2>
                        <p class="invoice-date">{{ $transaction->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="transaction-badge badge-{{ $transaction->type }}">
                        {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                    </div>
                </div>

                <!-- Main Info Grid -->
                <div class="detail-grid">
                    <div class="detail-box">
                        <span class="detail-label">Watch</span>
                        <p class="detail-value">{{ $transaction->watch->brand }} {{ $transaction->watch->model }}</p>
                        <span class="detail-hint">Serial: {{ $transaction->watch->serial_number ?? '—' }}</span>
                    </div>

                    <div class="detail-box">
                        <span class="detail-label">Client</span>
                        <p class="detail-value">{{ $transaction->client->first_name }} {{ $transaction->client->last_name }}</p>
                        <span class="detail-hint">{{ $transaction->client->email ?? '—' }}</span>
                    </div>

                    <div class="detail-box">
                        <span class="detail-label">Staff</span>
                        <p class="detail-value">{{ $transaction->staff->name }}</p>
                        <span class="detail-hint">{{ $transaction->staff->email }}</span>
                    </div>

                    <div class="detail-box">
                        <span class="detail-label">Amount</span>
                        <p class="detail-value amount">₱{{ number_format($transaction->amount, 2) }}</p>
                        <span class="detail-hint">Transaction value</span>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($transaction->notes)
                <div class="notes-section">
                    <span class="detail-label">Notes</span>
                    <p class="notes-content">{{ $transaction->notes }}</p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="detail-actions">
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-secondary">Edit Transaction</a>
                    <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" onsubmit="return confirm('Are you sure you want to delete this transaction?');" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="detail-sidebar">
            <div class="sidebar-widget">
                <h3>Transaction Summary</h3>
                <div class="widget-item">
                    <span>Invoice Number</span>
                    <strong>{{ $transaction->invoice_number }}</strong>
                </div>
                <div class="widget-item">
                    <span>Amount</span>
                    <strong>₱{{ number_format($transaction->amount, 2) }}</strong>
                </div>
                <div class="widget-item">
                    <span>Type</span>
                    <strong>{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</strong>
                </div>
                <div class="widget-divider"></div>
                <div class="widget-item">
                    <span>Recorded On</span>
                    <strong>{{ $transaction->created_at->format('M d, Y') }}</strong>
                </div>
                <div class="widget-item">
                    <span>Last Updated</span>
                    <strong>{{ $transaction->updated_at->format('M d, Y') }}</strong>
                </div>
            </div>

            <div class="sidebar-widget">
                <h3>Watch Info</h3>
                <div class="widget-item">
                    <span>Brand</span>
                    <strong>{{ $transaction->watch->brand }}</strong>
                </div>
                <div class="widget-item">
                    <span>Model</span>
                    <strong>{{ $transaction->watch->model }}</strong>
                </div>
                <div class="widget-item">
                    <span>Asking Price</span>
                    <strong>₱{{ number_format($transaction->watch->asking_price, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>