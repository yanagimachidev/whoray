<template>
    <div class="container">
        <div class="w-100 text-center">
            <div>
                <input type="file" name="image" accept="image/*" @change="setImage" class="mb-2" style="width:300px;">
            </div>
            <div v-if="imgSrc != ''" class="m-auto" style="width:300px; height:300px; border:1px solid gray;">
                <vue-cropper
                    ref="cropper"
                    :src="imgSrc"
                    :view-mode="2"
                    :initialAspectRatio="1/1"
                    :aspect-ratio="1/1"
                    :autoCropArea="0.8"
                    :img-style="{ 'width': '300px', 'height': '300px' }"
                ></vue-cropper>
            </div>
            <div class="mt-2">
                <button type="submit" @click="cropImage" v-if="imgSrc != ''" class="btn bg-primary text-white">設定する</button>
            </div>
        </div>
    </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
import loadImage from 'blueimp-load-image';

export default {
    components: {
        VueCropper
    },
    data() {
        return {
            imgSrc: "",
            filename: "",
            cropImg: ""
        };
    },
    methods: {
        setImage(e) {
            let file = e.target.files[0];
            this.filename = file.name;
            if (!file.type.includes("image/")) {
                alert("画像ファイルを指定してください。");
            }else if (typeof FileReader === "function") {
                loadImage.parseMetaData(
                    file,
                    (data) => {
                        let options = {
                            canvas: true
                        };
                        if (data.exif) {
                            options.orientation = data.exif.get('Orientation');
                        }

                        loadImage(
                            file,
                            async (canvas) => {
                                let data = canvas.toDataURL(file.type);
                                let blob = this.base64ToBlob(data, file.type);
                                let reader = new FileReader();
                                reader.readAsDataURL(blob);
                                reader.onload = event => {
                                    if(this.imgSrc != ""){
                                        this.$refs.cropper.replace(event.target.result);
                                    }
                                    this.imgSrc = event.target.result;
                                };
                            },
                            options
                        );
                    }
                );
            } else {
                alert("ブラウザが対応しておりません。");
            }
        },
        base64ToBlob(base64, fileType) {
            let bin = window.atob(base64.replace(/^.*,/, ''));
            let buffer = new Uint8Array(bin.length);
            for (let i = 0; i < bin.length; i++) {
                buffer[i] = bin.charCodeAt(i);
            }
            return new Blob([buffer.buffer], {
                type: fileType ? fileType : 'image/png'
            });
        },
        async cropImage() {
            this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL("image/png");
            const response = await axios.post(`/profileimage`, {
                profileImage: this.cropImg
            });
            window.location.href = "/mypage";
        }
    }
};
</script>