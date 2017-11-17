<?php
namespace common\modules\blog\models;

use common\modules\blog\Module;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class ImageUploader extends Model
{
    /** @var  UploadedFile[] */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function attributeLabels()
    {
        return [
          'imageFiles' => 'Загрузка изображений'
        ];
    }

    public function upload(): array
    {
        /** @var BlogImage[] $images */
        $images = [];
        $pathImages = [];
        $hasError = false;

        if($this->validate()) {
            foreach($this->imageFiles as $file) {
                $newName  = md5($file->baseName . microtime()) . '.' . $file->extension;
                $path = Module::getInstance()->uploadPath . '/' . $newName;


                // save file
                if(!$file->hasError && $file->saveAs($path)) {
                    $pathImages[] = $path;
                } else {
                    $hasError = true;
                    break;
                }
                // write to db
                $image = new BlogImage(['origin_name' => $file->name, 'name' => $newName]);
                if($image->save()) {
                    $images[] = $image;
                } else {
                    $this->addErrors($image->getErrors());
                    $hasError = true;
                    break;
                }
            }
            // if has errors -> revert
            if($hasError) {
                $lengthPathImages = count($pathImages);
                for($iter = 0; $iter < $lengthPathImages; $iter++) {
                    if(is_file($pathImages[$iter])) {
                        unlink($pathImages[$iter]);
                    }
                    unset($pathImages[$iter]);
                }
                $lengthImages = count($images);
                for($iKey = 0; $iKey < $lengthImages; $iKey++) {
                    $images[$iKey]->delete();
                    unset($images[$iKey]);
                }
            }
        }

        return $images;
    }

}