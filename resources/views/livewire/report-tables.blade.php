<div class="fi-sc fi-sc-has-gap fi-grid">
    @foreach ($this->tables as $table)
        <x-reports.report-table
            :type="$this->getRecord()->type"
            :title="data_get($table, 'title')"
            :columns="data_get($table, 'columns')"
            :data="data_get($table, 'data')" />
    @endforeach

    @if ($this->tables->hasPages())
        <div
            x-data="{
                isSticky: false,
            
                evaluatePageScrollPosition: function() {
                    this.isSticky =
                        document.body.scrollHeight >=
                        window.scrollY + window.innerHeight * 2
                },
            }"
            x-init="evaluatePageScrollPosition"
            x-on:scroll.window="evaluatePageScrollPosition"
            x-bind:class="{
                'fi-sticky sticky bottom-0 -mx-4 transform bg-white p-4 shadow-lg ring-1 ring-gray-950/5 transition dark:bg-gray-900 dark:ring-white/10 md:bottom-4 md:rounded-xl': isSticky,
            }"
            class="fi-form-actions">

            {{ $this->tables->links() }}
        </div>
    @endif
</div>
