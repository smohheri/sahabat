<div class="character-master-page">
    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-purple">
                <i class="fas <?php echo $icon_class; ?>"></i>
            </div>
            <div>
                <h2><?php echo $heading; ?></h2>
                <p><?php echo $subheading; ?></p>
            </div>
        </div>
    </div>

    <div class="stats-row">
        <?php foreach ($stat_cards as $card): ?>
            <div class="stat-card <?php echo $card['class']; ?>">
                <div class="stat-icon"><i class="fas <?php echo $card['icon']; ?>"></i></div>
                <div class="stat-info">
                    <span class="stat-number"><?php echo $card['value']; ?></span>
                    <span class="stat-label"><?php echo $card['label']; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas <?php echo $table_icon; ?>"></i> <?php echo $table_title; ?></h3>
            <span class="data-count"><?php echo count($rows); ?> data</span>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $col): ?>
                                <th><?php echo $col; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?php echo $value; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?php echo count($columns); ?>" class="text-center text-muted">
                                    <?php echo $empty_message; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .character-master-page {
        padding: 10px;
    }

    .character-master-page .page-header {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .character-master-page .header-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .character-master-page .header-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .character-master-page .bg-purple {
        background: rgba(111, 66, 193, 0.12);
        color: #6f42c1;
    }

    .character-master-page .header-info h2 {
        margin: 0 0 5px;
        font-size: 22px;
        font-weight: 600;
        color: #2d3748;
    }

    .character-master-page .header-info p {
        margin: 0;
        color: #718096;
        font-size: 14px;
    }

    .character-master-page .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .character-master-page .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .character-master-page .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .character-master-page .stat-blue .stat-icon {
        background: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }

    .character-master-page .stat-green .stat-icon {
        background: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    .character-master-page .stat-orange .stat-icon {
        background: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
    }

    .character-master-page .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        line-height: 1;
    }

    .character-master-page .stat-label {
        font-size: 13px;
        color: #718096;
        margin-top: 5px;
        display: block;
    }

    .character-master-page .data-panel {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .character-master-page .panel-header {
        padding: 20px 25px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .character-master-page .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .character-master-page .panel-header i {
        color: #4e73df;
    }

    .character-master-page .data-count {
        background: #f8fafc;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        color: #718096;
        font-weight: 500;
    }

    .character-master-page .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .character-master-page .data-table th {
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .character-master-page .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
        font-size: 14px;
        color: #2d3748;
    }

    .character-master-page .data-table tbody tr:hover {
        background: #f8fafc;
    }

    @media (max-width: 992px) {
        .character-master-page .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>