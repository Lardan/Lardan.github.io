$(function() {
    function makeTabs(contId) {
        var tabContainers = $('#' + contId + ' div.tabs > .tab');
        tabContainers.hide().filter(':first').show();
        $('#' + contId + ' div.tabs div.buttons a').click(function() {
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            $('#' + contId + ' div.tabs div.buttons a').removeClass('active');
            $(this).addClass('active');
            return false
        }).filter(':first').click()
    }
    makeTabs('tabs-1');
    makeTabs('tabs-2');
    makeTabs('tabs-3');
    makeTabs('tabs-4');
    makeTabs('tabs-5');
});