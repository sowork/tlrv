<template>
    <div>
        <div class="content_wrap">
            <div class="zTreeDemoBackground left">
                <ul id="ztree" class="ztree"></ul>
            </div>
            <div class="zTreeDemoBackground right">
                uid：
                <br>
                <input type="text" v-model="node_uid">
                <br>
                node_value：
                <br>
                <input type="text" v-model="node_value">
                <br>
                addition:<br>
                <textarea  id="" cols="30" rows="10" v-model="additionData"></textarea>
                <p>
                    <button @click="saveNode">保存</button>
                    <button @click="rebuild">重建</button>
                </p>
            </div>
        </div>
        <div id="rMenu">
            <ul>
                <li id="m_add" @click="addTreeNode();">增加节点</li>
                <li id="m_del" @click="removeTreeNode();">删除节点</li>
                <li id="m_check" @click="checkTreeNode(true);">Check节点</li>
                <li id="m_unCheck" @click="checkTreeNode(false);">unCheck节点</li>
            </ul>
        </div>
    </div>
</template>


<script>
    import "../zTree_v3/js/jquery-1.4.4.min.js"
    import "../zTree_v3/js/jquery.ztree.core.js"
    import "../zTree_v3/js/jquery.ztree.excheck.js"
    import "../zTree_v3/js/jquery.ztree.exedit.js"

    let zTree, rMenu, lastNode;
    var curDragNodes, className = "dark";

    export default {
        name: 'zTree',
        components: {
        },
        data(){
            let that = this;
            return {
                node_value: '',
                additionData:'',
                node_uid:'',
                zNodes : [],
                setting:{
                    view: {
                        dblClickExpand: false
                    },
                    data: {
                        simpleData: {
                            enable: true
                        }
                    },
                    callback: {
                        beforeDragOpen: that.beforeDragOpen,
                        beforeDrag: that.beforeDrag,
                        onRightClick: that.OnRightClick,
                        onClick: that.onClick,
                        onRename: that.onRename,
                        onNodeCreated: that.onNodeCreated,
                        onDrop: that.onDrop
                    },
                    edit: {
                        drag: {
                            autoExpandTrigger: true,
                            prev: that.dropPrev,
                            inner: that.dropInner,
                            next: that.dropNext
                        },
                        enable: true,
                        showRemoveBtn: false,
                        showRenameBtn: false,
                    },
                },
            }
        },
        methods: {
            rebuild(){
                axios.get('/tlrv/rebuild', {
                }).then(function (response) {
                    if(response.data.code == '0'){
                        return true;
                    }else{
                        alert(response.data.msg);
                        return false;
                    }
                }).catch(function(error){
                    alert('网络异常，请稍后重试！');
                });
            },
            onDrop(event, treeId, treeNodes, targetNode, moveType){
                if(moveType){
                    axios.post('/tlrv/' + treeNodes[0].id, {
                        '_method': 'put',
                        'tar_id':targetNode ? targetNode.id : 0,
                        'type' : moveType
                    }).then(function (response) {
                        if(response.data.code == '0'){
                            return true;
                        }else{
                            alert(response.data.msg);
                            return false;
                        }
                    }).catch(function(error){
                        alert('网络异常，请稍后重试！');
                    });
                }
            },
            dropPrev(treeId, nodes, targetNode) {
                var pNode = targetNode.getParentNode();
                if (pNode && pNode.dropInner === false) {
                    return false;
                } else {
                    for (var i=0,l=curDragNodes.length; i<l; i++) {
                        var curPNode = curDragNodes[i].getParentNode();
                        if (curPNode && curPNode !== targetNode.getParentNode() && curPNode.childOuter === false) {
                            return false;
                        }
                    }
                }
                return true;
            },
            dropInner(treeId, nodes, targetNode) {
                if (targetNode && targetNode.dropInner === false) {
                    return false;
                } else {
                    for (var i=0,l=curDragNodes.length; i<l; i++) {
                        if (!targetNode && curDragNodes[i].dropRoot === false) {
                            return false;
                        } else if (curDragNodes[i].parentTId && curDragNodes[i].getParentNode() !== targetNode && curDragNodes[i].getParentNode().childOuter === false) {
                            return false;
                        }
                    }
                }
                return true;
            },
            dropNext(treeId, nodes, targetNode) {
                var pNode = targetNode.getParentNode();
                if (pNode && pNode.dropInner === false) {
                    return false;
                } else {
                    for (var i=0,l=curDragNodes.length; i<l; i++) {
                        var curPNode = curDragNodes[i].getParentNode();
                        if (curPNode && curPNode !== targetNode.getParentNode() && curPNode.childOuter === false) {
                            return false;
                        }
                    }
                }
                return true;
            },
            beforeDrag(treeId, treeNodes) {
                className = (className === "dark" ? "":"dark");
                for (var i=0,l=treeNodes.length; i<l; i++) {
                    if (treeNodes[i].drag === false) {
                        curDragNodes = null;
                        return false;
                    } else if (treeNodes[i].parentTId && treeNodes[i].getParentNode().childDrag === false) {
                        curDragNodes = null;
                        return false;
                    }
                }
                curDragNodes = treeNodes;
                return true;
            },
            beforeDragOpen(treeId, treeNode) {
                autoExpandNode = treeNode;
                return true;
            },
            initData(){
                axios.get('/tlrv/search', {
                    params: {
                    }
                }).then((response) => {
                    if(response.data.code == '0'){
                        this.zNodes = response.data.data;
                        $.fn.zTree.init($("#ztree"), this.setting, this.zNodes);
                        zTree = $.fn.zTree.getZTreeObj("ztree");
                        zTree.expandAll(true);
                        rMenu = $("#rMenu");
                    }
                }).catch(function(error){
                    alert('网络异常，请稍后重试！');
                })
            },
            OnRightClick(event, treeId, treeNode) {
                if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
                    zTree.cancelSelectedNode();
                    this.showRMenu("root", event.clientX, event.clientY);
                } else if (treeNode && !treeNode.noR) {
                    zTree.selectNode(treeNode);
                    this.showRMenu("node", event.clientX, event.clientY);
                }
                lastNode = treeNode;
            },
            onNodeCreated(event, treeId, treeNode){
                this.node_value = '';
                this.additionData = '';
                this.node_uid = '';
            },
            onClick(event, treeId, treeNode){
                if(treeNode == lastNode){
                    return;
                }
                this.node_value = treeNode.node_value ? treeNode.node_value : '';
                this.additionData = treeNode.addition_data ? treeNode.addition_data : '';
                this.node_uid = treeNode.node_uid ? treeNode.node_uid : '';
//                if(this.node_value !== '' || this.additionalData !== ''){
//                    if(confirm('确定清空value数据和附加内容么?')){
//                        this.node_value = '';
//                        this.additionalData = '';
//                    }else{
//                        zTree.cancelSelectedNode(treeNode);
//                        zTree.selectNode(lastNode);
//                        return;
//                    }
//                }
                lastNode = treeNode;
            },
            onRename(event, treeId, treeNode, isCancel){
                var parentNode = zTree.getNodeByTId(treeNode.parentTId);
                if(isCancel){
                    if(parentNode){
                        zTree.selectNode(parentNode);
                    }
                    zTree.removeNode(treeNode);
                    return;
                }

                if(treeNode.name == '') {
                    zTree.removeNode(treeNode);
                    return;
                }
                axios.post('/tlrv', {
                    id: parentNode ? parentNode.id : 0,
                    node_key:treeNode.name,
                }).then(function (response) {
                    if(response.data.code == '0'){
                        treeNode.id = response.data.data.id;
                    }else{
                        alert(response.data.msg);
                    }
                }).catch(function(error){
                    alert('网络异常，请稍后重试！');
                })
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
                this.hideRMenu();
                var newNode = { name:""};
                var nodes = zTree.getSelectedNodes();
                var TreeNode;
                if (zTree.getSelectedNodes()[0]) {
                    newNode.checked = zTree.getSelectedNodes()[0].checked;
                    TreeNode = zTree.addNodes(zTree.getSelectedNodes()[0], newNode);
                } else {
                    TreeNode = zTree.addNodes(null, newNode);
                }
                zTree.editName(TreeNode[0]);
            },
            removeTreeNode() {
                this.hideRMenu();
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    if (nodes[0].children && nodes[0].children.length > 0) {
                        var msg = "要删除的节点是父节点，如果删除将连同子节点一起删掉。\n\n请确认！";
                        if (confirm(msg)==false){
                            return false;
                        }
                    }
                    axios.post('/tlrv/' + nodes[0].id, {
                        '_method' : 'DELETE',
                    }).then((response) => {
                        if(response.data.code == '0'){
                            zTree.removeNode(nodes[0]);
                        }else{
                            alert(response.data.msg)
                        }
                    }).catch(function(error){
                        alert('网络异常，请稍后重试！');
                    })
                }
            },
            checkTreeNode(checked) {
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    zTree.checkNode(nodes[0], checked, true);
                }
                this.hideRMenu();
            },
            saveNode(){
                var nodeTree = zTree.getSelectedNodes()[0];
                if(! nodeTree){
                    alert('请选择至少一个节点');
                    return false;
                }
                axios.post('/tlrv/addition', {
                    id: nodeTree.id,
                    addition_data: this.additionData,
                    node_value: this.node_value,
                    node_uid: this.node_uid,
                }).then((response) => {
                    if(response.data.code == '0'){
                        nodeTree.node_value = this.node_value;
                        nodeTree.addition_data = this.additionData;
                        nodeTree.node_uid = this.node_uid;
                    }else{
                        alert('保存失败');
                    }
                }).catch(function(error){
                    alert('网络异常，请稍后重试！');
                })
            }
        },
        mounted(){
            this.initData();
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