import RunCommon from './../common/run_common';
import { loadCss } from './../common/lazyload_file'
import toast  from 'toastr';
import 'jquery-modal'

var DocumentList = {
    init()
    {
        this.loadCssLazy();
        this.showSort();
        this.showItemFilterDesktop();
        this.showNotFoundFile();

        if (typeof DOWNLOAD != "undefined")
        {
            let $elementLink = $("#js-auto-download");
            let URL = $elementLink.attr('href');
            if(URL)
            {
                window.location.href = URL;
            }
        }
    },

    showNotFoundFile()
    {
        $(".js-show-not-file").click(function (event) {
            toast.warning("File không tồn tại. Hãy download tài liệu thuộc gói combo phía dưới");
        })
    },


    showItemFilterDesktop()
    {
        $(".js-item-filter").click(function (event) {
            let $this = $(this);
            let $item = $this.find("div");
            $item.slideToggle();
        })
    },


    showSort() {
        $(".js-show-sort").click(function (event) {
            event.preventDefault();
            let $nextUl = $(this).next();
            $nextUl.slideToggle();
        })
    },

    loadCssLazy()
    {
        if (typeof CSS != 'undefined')
        {
            loadCss(CSS);
        }
    },
    

};
$(function () {
    DocumentList.init();
    RunCommon.init();
});
