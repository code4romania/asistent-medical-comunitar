<x-layouts.error
    :title="__('error.403.title')"
    :code="403"
    :message="__($exception->getMessage() ?: 'error.403.message')" />
