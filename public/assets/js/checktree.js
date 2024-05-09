(function ($) {
    $.fn.checktree = function () {
        this.find(':checkbox').on('click', function (event) {
            event.stopPropagation();

            const clickedCheckbox = $(this);
            const isChecked = clickedCheckbox.is(':checked');
            const parentLi = clickedCheckbox.closest('li');
            const parentUls = parentLi.parents('ul');

            parentLi.find(':checkbox').prop('checked', isChecked);

            parentUls.each(function () {
                const parentUl = $(this);
                const allCheckboxes = parentUl.find(':checkbox');
                const checkedCheckboxes = parentUl.find(':checkbox:checked');
                const parentState = allCheckboxes.length === checkedCheckboxes.length;

                parentUl.siblings(':checkbox').prop('checked', parentState);
            });
        });

        return this;
    };
})(jQuery);
