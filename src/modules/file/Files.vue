<template>
  <div class="files-wrapper">
    <button class="btn btn-primary pull-right" @click="redirect('/editor/v2')"><i class="fa fa-plus"></i> Add Template</button>
    <generic-filter v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieve($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th', 'th-large']">
    </generic-filter>
      <div class="container-files" v-if="categoryParameter === null">
           <ul v-if="folders !== null" v-for="(item, index) in folders" :key="index" :class="`folder ${listStyle}`">
              <div v-if="item !== null" class ="folder-wrapper" id="file-list" @click="redirect('/files/' + item, item)">
                <i id="file" class="fas fa-folder"></i><span id="filename"> {{item}}</span>
              </div>
           </ul>
          <dynamic-empty v-if="folders === null" :title="'No products yet!'" :action="'Please add new designs.'" :icon="'far fa-smile'" :iconColor="'text-primary'"></dynamic-empty>
      </div>
    <div v-else class="container-files">
      <li><span @click="redirect('/files')">File Management </span><i class="fas fa-angle-right"></i> {{selectedFolder}}</li>
      <category-contents :listStyle="listStyle" :category="categoryParameter"></category-contents>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.files-wrapper{
  width:100%;
  height: auto;
  float: left;
  margin-bottom: 15px;
}
.container-files{
  float: left;
  width: 100%;
}
.fa-folder{
  padding-right: 5px;
}
.btn-primary{
  margin-bottom: 10px;
}
.list-style {
  min-height: 50px !important;
  overflow-y: hidden !important;
  border-bottom: solid 1px $gray;
}
.three-columns{
  padding: 5px 0 5px 0 !important;
  width: 33% !important;
  float: left !important;
  padding-bottom: 5px !important;
  border-bottom: solid 1px $gray;
}
.two-columns{
  padding: 5px 0 5px 0 !important;
  width: 50% !important;
  float: left !important;
  padding-bottom: 5px !important;
  border-bottom: solid 1px $gray;
}
li{
  list-style: none;
}
span{
  cursor: pointer;
}
ul{
  list-style: none;
  margin: 0px;
  padding: 0px;
}
ul li{
  height: 50px;
  line-height: 50px;
  padding-left: 10px;
}
.folder{
  min-height: 50px !important;
  padding:10px 0px 10px 10px !important;
}
.folder:hover{
  cursor: pointer;
  color: $primary;
  background: $gray;
  min-height: 50px;
}
ul div i{
  font-size: 24px;
  color: $primary;
}
@media (max-width: 991px){
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve({title: 'asc'})
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      category: [{
        title: 'Personnal',
        sorting: [{
          title: 'Title ascending',
          payload: 'title',
          payload_value: 'asc'
        }, {
          title: 'Title descending',
          payload: 'title',
          payload_value: 'desc'
        }]
      }],
      folders: null,
      selectedFolder: null,
      categoryParameter: this.$route.params.category ? this.$route.params.category : null,
      listStyle: 'list-style'
    }
  },
  components: {
    'dynamic-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue'),
    'category-contents': require('modules/file/Contents.vue'),
    'generic-filter': require('components/increment/ecommerce/marketplace/Filter.vue')
  },
  watch: {
    '$route.params.category': function(){
      if(this.$route.params.category){
        this.categoryParameter = this.$route.params.category
      }else{
        this.categoryParameter = null
      }
    }
  },
  methods: {
    redirect(parameter, folderName){
      this.selectedFolder = folderName
      ROUTER.push(parameter)
      if(parameter === 'editor/v2'){
        AUTH.mode = 1
      }
    },
    retrieve(sort){
      console.log(sort)
      let parameter = {
        sort: sort.title,
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('templates/retrieve_categories', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.folders = response.data
        }else{
          this.folders = null
        }
        console.log(this.folders)
      })
    },
    manageGrid(event){
      switch(event){
        case 'th-large': this.listStyle = 'two-columns'
          break
        case 'th': this.listStyle = 'three-columns'
          break
        case 'list': this.listStyle = 'list-style'
          break
      }
    }
  }
}
</script>
