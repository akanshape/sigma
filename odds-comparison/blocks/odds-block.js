(function (wp) {
    const { registerBlockType } = wp.blocks;

    registerBlockType('ocp/odds-block', {
        title: 'Odds Comparison',
        icon: 'chart-bar',
        category: 'widgets',
        edit: function () {
            return wp.element.createElement(
                'p',
                {},
                'Odds Comparison block – content will be rendered on the frontend.'
            );
        },
        save: function () {
            // Server-side rendered – nothing saved here
            return null;
        },
    });
})(window.wp);
