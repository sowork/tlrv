<template>
    <div>
        <div class="content_wrap">
            <div class="zTreeDemoBackground left">
                <ul id="ztree" class="ztree"></ul>
            </div>
        </div>
        <div id="rMenu">
            <ul>
                <li id="m_add" onclick="addTreeNode();">增加节点</li>
                <li id="m_del" onclick="removeTreeNode();">删除节点</li>
                <li id="m_check" onclick="checkTreeNode(true);">Check节点</li>
                <li id="m_unCheck" onclick="checkTreeNode(false);">unCheck节点</li>
                <li id="m_reset" onclick="resetTree();">恢复zTree</li>
            </ul>
        </div>
    </div>
</template>


<script>
    import "../zTree_v3/js/jquery-1.4.4.min.js"
    import "../zTree_v3/js/jquery.ztree.core.js"
    import "../zTree_v3/js/jquery.ztree.excheck.js"
    import "../zTree_v3/js/jquery.ztree.exedit.js"

    let zTree, rMenu;
    let addCount = 1;

    export default {
        name: 'zTree',
        components: {
        },
        data(){
            let that = this;

            return {
                setting:{
                    view: {
                        dblClickExpand: false
                    },
                    check: {
                        enable: true
                    },
                    callback: {
                        onRightClick: that.OnRightClick
                    },
                },
                zNodes : [
                    {id:1, name:"无右键菜单 1", open:true, noR:true,
                        children:[
                            {id:11, name:"节点 1-1", noR:true},
                            {id:12, name:"节点 1-2", noR:true}

                        ]},
                    {id:2, name:"右键操作 2", open:true,
                        children:[
                            {id:21, name:"节点 2-1"},
                            {id:22, name:"节点 2-2"},
                            {id:23, name:"节点 2-3"},
                            {id:24, name:"节点 2-4"}
                        ]},
                    {id:3, name:"右键操作 3", open:true,
                        children:[
                            {id:31, name:"节点 3-1"},
                            {id:32, name:"节点 3-2"},
                            {id:33, name:"节点 3-3"},
                            {id:34, name:"节点 3-4"}
                        ]}
                ]
            }
        },
        methods: {
            OnRightClick(event, treeId, treeNode) {
                if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
                    zTree.cancelSelectedNode();
                    this.showRMenu("root", event.clientX, event.clientY);
                } else if (treeNode && !treeNode.noR) {
                    zTree.selectNode(treeNode);
                    this.showRMenu("node", event.clientX, event.clientY);
                }
            },
            showRMenu(type, x, y) {
                $("#rMenu ul").show();
                if (type=="root") {
                    $("#m_del").hide();
                    $("#m_check").hide();
                    $("#m_unCheck").hide();
                } else {
                    $("#m_del").show();
                    $("#m_check").show();
                    $("#m_unCheck").show();
                }

                y += document.body.scrollTop;
                x += document.body.scrollLeft;
                rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});

                $("body").bind("mousedown", this.onBodyMouseDown);
            },
            hideRMenu() {
                if (rMenu) rMenu.css({"visibility": "hidden"});
                $("body").unbind("mousedown", this.onBodyMouseDown);
            },
            onBodyMouseDown(event){
                if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
                    rMenu.css({"visibility" : "hidden"});
                }
            },
            addTreeNode() {
                hideRMenu();
                var newNode = { name:"增加" + (addCount++)};
                if (zTree.getSelectedNodes()[0]) {
                    newNode.checked = zTree.getSelectedNodes()[0].checked;
                    zTree.addNodes(zTree.getSelectedNodes()[0], newNode);
                } else {
                    zTree.addNodes(null, newNode);
                }
            },
            removeTreeNode() {
                hideRMenu();
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    if (nodes[0].children && nodes[0].children.length > 0) {
                        var msg = "要删除的节点是父节点，如果删除将连同子节点一起删掉。\n\n请确认！";
                        if (confirm(msg)==true){
                            zTree.removeNode(nodes[0]);
                        }
                    } else {
                        zTree.removeNode(nodes[0]);
                    }
                }
            },
            checkTreeNode(checked) {
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    zTree.checkNode(nodes[0], checked, true);
                }
                hideRMenu();
            },
            resetTree() {
                hideRMenu();
                $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            }
        },
        mounted(){
            $.fn.zTree.init($("#ztree"), this.setting, this.zNodes);
            zTree = $.fn.zTree.getZTreeObj("ztree");
            rMenu = $("#rMenu");
        }
    }
</script>

<style>
    @import "../zTree_v3/css/demo.css";
    @import "../zTree_v3/css/zTreeStyle/zTreeStyle.css";

    div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;}
    div#rMenu ul li{
        margin: 1px 0;
        padding: 0 5px;
        cursor: pointer;
        list-style: none outside none;
        background-color: #DFDFDF;
    }
</style>