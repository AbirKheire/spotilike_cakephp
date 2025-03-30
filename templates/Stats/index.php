<h2>
    <?php if ($isAdmin): ?>
        Global stats
    <?php else: ?>
        Your statys
    <?php endif; ?>
</h2>

<style>
    .stats-section {
        margin-bottom: 40px;
    }

    .card-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .card {
        flex: 1 1 200px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background-color: #f9f9f9;
    }

    .card h4 {
        margin-top: 0;
        font-size: 18px;
    }

    .card p {
        margin: 5px 0;
    }

    h3 {
        border-bottom: 2px solid #ddd;
        padding-bottom: 6px;
    }

    canvas {
        max-width: 100%;
        margin: 20px 0;
    }
</style>

<div class="stats-section">
    <h3>Top 5 most listened artists</h3>
    <canvas id="topArtistsChart" height="150"></canvas>
</div>

<
<div class="stats-section">
    <h3>Top 5 most follwoed artists</h3>
    <div class="card-group">
        <?php foreach ($topArtists as $artist): ?>
            <div class="card">
                <h4><?= h($artist->name) ?></h4>
                <p><?= $artist->favorites_count ?> favorites</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="stats-section">
    <h3>Top 5 most liked Albums</h3>
    <div class="card-group">
        <?php foreach ($topAlbums as $album): ?>
            <div class="card">
                <h4><?= h($album->title) ?></h4>
                <p> <?= $album->favorites_count ?> favorites</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php if ($isAdmin): ?>
<div class="stats-section">
    <h3>Top 5 users with the most favorites</h3>
    <div class="card-group">
        <?php foreach ($topUsers as $user): ?>
            <div class="card">
                <h4><?= h($user->username) ?></h4>
                <p> <?= $user->favorites_count ?> saved favorites</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('topArtistsChart').getContext('2d');
    const topArtistsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(fn($a) => $a->name, $topArtists->toArray())) ?>,
            datasets: [{
                label: 'Nombre de favoris',
                data: <?= json_encode(array_map(fn($a) => $a->favorites_count, $topArtists->toArray())) ?>,
        
                borderColor: '#333',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
