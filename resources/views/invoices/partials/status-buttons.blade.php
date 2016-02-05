@if($totals['paid'] > 0)
    <a href="?status=paid" class="btn btn-success">Paid <span class="badge">${{ $totals['paid'] }}</span></a>
@endif

@if($totals['pending'] > 0)
    <a href="?status=pending" class="btn btn-info">Pending <span class="badge">${{ $totals['pending'] }}</span></a>
@endif

@if($totals['overdue'] > 0)
    <a href="?status=overdue" class="btn btn-warning">Overdue <span class="badge">${{ $totals['overdue'] }}</span></a>
@endif

@if($totals['error'] > 0)
    <a href="?status=error" class="btn btn-danger">Error <span class="badge">${{ $totals['error'] }}</span></a>
@endif
