<template>
    <form @submit.prevent="setAvatar">
        <div class="container" @click.prevent="triggerButton">
            <!-- <img src="./../../assets/logo.png" alt="Avatar" class="image"> -->
            <!-- <img :src="avatar" alt="Avatar" class="image"> -->

            <vue-load-image>
                <img slot="image" :src="avatar"/>
                <img slot="preloader" src="./../../assets/image-loader.gif"/>
                <div slot="error">N/A</div>
            </vue-load-image>

            <div class="overlay">
                <span uk-icon="icon: camera"></span><br/>
            </div>
            <progress max="100" v-bind:class="{'uk-hidden' : hidden}" :value.prop="uploadPercent"/>
        </div>
        <input type="file" name="fileUpload" ref="file" accept="image/png,image/gif,image/jpeg" id="fileUpload" v-on:change="uploadFile()">
    </form>
</template>

<script>
import VueLoadImage from 'vue-load-image'
import axios from 'axios'

export default {
    data() {
        return {
            file: '',
            upload: '',
            uploadPercent: 0,
            hidden: true,
            avatar: '',
        }
    },

    components: {
        'vue-load-image': VueLoadImage
    },

    created () {
       this.getAvatar()
    },

    methods: {
        triggerButton() {
            document.getElementById("fileUpload").click()
        },
        uploadFile() {

           this.upload = document.getElementById("fileUpload")

           if(this.upload) {
               if( this.upload.files[0] && this.upload.files[0].size < 5000000) {
                    this.file = this.upload.files[0]          
                    let formData = new FormData()
                    formData.append('image', this.file)
                    
                    let header = {
                        headers: {
                            Authorization: 'Bearer '+this.$store.state.token,
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function (progressEvent) {
                            this.uploadPercent = parseInt( Math.round ( progressEvent.loaded / progressEvent.total ) * 100 )
                            this.hidden = false
                        }.bind(this)
                    }

                    axios.post('/user/profile/avatar/upload', formData, header)
                    .then(() => {
                        // this.getAvatar()
                        setTimeout(() => {
                            this.uploadPercent = 0
                            this.hidden = true
                            this.$router.go() 
                        }, 1500)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                } else {
                    console.log("File is more than 5MB")
                }
            }
        },

        getAvatar() {

            let header = {
                headers: { Authorization: 'Bearer '+this.$store.state.token }
            }
            
            axios.get('/user/profile/avatar',  header )
            .then( response => {
                this.avatar = response.data
            })
            .catch( error => {
                console.log(error)
            })
        }
        
    }
}
</script>

<style>

* {box-sizing: border-box}

/* Container needed to position the overlay. Adjust the width as needed */
.container {
  position: relative;
  width: auto;
  max-width: 150px;
}

/* Make the image to responsive */
.image {
  display: block;
}

/* The overlay effect - lays on top of the container and over the image */
.overlay {
  cursor: pointer;
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0);
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  color: #f1f1f1;
  width: 100%;
  height: 100%;
  transition: .5s ease;
  opacity:0;
  color: white;
  font-size: 20px;
  padding: 20px;
  text-align: center;
}
.overlay > span {
  cursor: pointer;
  z-index: 1;
  position: absolute;
  left: 55px;
  bottom: 42%;
  right: 55px;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

/* When you mouse over the container, fade in the overlay title */
.container:hover .overlay {
  opacity: .6;
}

form input[type="file"] {
  display: none;
  cursor: pointer;
}

progress {
    color:rgb(0, 0, 0);
}

</style>