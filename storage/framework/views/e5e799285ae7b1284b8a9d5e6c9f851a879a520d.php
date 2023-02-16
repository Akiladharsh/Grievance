<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]); ?>
<?php foreach (array_filter(([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $action = $column->getAction();
    $alignment = $column->getAlignment();
    $name = $column->getName();
    $shouldOpenUrlInNewTab = $column->shouldOpenUrlInNewTab();
    $tooltip = $column->getTooltip();
    $url = $column->getUrl();

    $slot = $column->viewData(['recordKey' => $recordKey]);
?>

<div
    <?php echo e($attributes->class([
        'filament-tables-column-wrapper',
        match ($alignment) {
            'start' => 'text-start',
            'center' => 'text-center',
            'end' => 'text-end',
            'left' => 'text-left',
            'right' => 'text-right',
            'justify' => 'text-justify',
            default => null,
        },
    ])); ?>

    <?php if($tooltip): ?>
        x-data="{}"
        x-tooltip.raw="<?php echo e($tooltip); ?>"
    <?php endif; ?>
>
    <?php if($isClickDisabled): ?>
        <?php echo e($slot); ?>

    <?php elseif($url || ($recordUrl && $action === null)): ?>
        <a
            href="<?php echo e($url ?: $recordUrl); ?>"
            <?php echo $shouldOpenUrlInNewTab ? 'target="_blank"' : null; ?>

            class="block"
        >
            <?php echo e($slot); ?>

        </a>
    <?php elseif($action || $recordAction): ?>
        <?php
            if ($action instanceof \Filament\Tables\Actions\Action) {
                $wireClickAction = "mountTableAction('{$action->getName()}', '{$recordKey}')";
            } elseif ($action) {
                $wireClickAction = "callTableColumnAction('{$name}', '{$recordKey}')";
            } else {
                if ($this->getCachedTableAction($recordAction)) {
                    $wireClickAction = "mountTableAction('{$recordAction}', '{$recordKey}')";
                } else {
                    $wireClickAction = "{$recordAction}('{$recordKey}')";
                }
            }
        ?>

        <button
            wire:click="<?php echo e($wireClickAction); ?>"
            wire:target="<?php echo e($wireClickAction); ?>"
            wire:loading.attr="disabled"
            wire:loading.class="cursor-wait opacity-70"
            type="button"
            class="block w-full text-start"
        >
            <?php echo e($slot); ?>

        </button>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/vendor/filament/tables/src/../resources/views/components/columns/column.blade.php ENDPATH**/ ?>