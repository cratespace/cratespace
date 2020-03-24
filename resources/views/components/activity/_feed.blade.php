<div class="mb-4">
    <h4 class="text-xl font-bold">Recent Activity</h4>

    <p class="text-gray-600">
        Showing the most recent activities categorized by day.
    </p>
</div>

@include('components.activity._list', ['activity' => $activity])
