<p><strong>Programme:</strong> {{ $rule->programme->programme_name ?? 'All' }}</p>
<p><strong>Semester:</strong> {{ $rule->semester->semester_name ?? 'All' }}</p>
<p><strong>Hostel:</strong> {{ $rule->hostel ?? 'All' }}</p>
<p><strong>International:</strong> {{ $rule->international ?? 'All' }}</p>
<p><strong>Amount:</strong> ${{ number_format($rule->amount, 2) }}</p>
