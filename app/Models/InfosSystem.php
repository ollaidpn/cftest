<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfosSystem extends Model
{
    use HasFactory;

    public function getLogo() {
        $logo = str_replace('\\', '/', $this->logo);

        $check_img = public_path('storage/'.$logo);

        if(file_exists($check_img) && $this->logo !== null)
            return asset('storage/'.$logo);
        else
            return asset('assets/admin-formateurs/images/logoFC.png');
    }

    public function getImgHeader() {
        $img_header = str_replace('\\', '/', $this->img_header);

        $check_img = public_path('storage/'.$img_header);

        if(file_exists($check_img) && $this->img_header !== null)
            return asset('storage/'.$img_header);
        else
            return asset('assets/front-clients/images/background/inner-pagebg.jpg');
    }

    public function getImgSlider() {
        $img_slider = str_replace('\\', '/', $this->img_slider);

        $check_img = public_path('storage/'.$img_slider);

        if(file_exists($check_img) && $this->img_slider !== null)
            return asset('storage/'.$img_slider);
        else
            return asset('assets/front-clients/images/background/6.jpg');
    }

    public function getFavicon() {
        $favicon = str_replace('\\', '/', $this->favicon);

        $check_img = public_path('storage/'.$favicon);

        if(file_exists($check_img) && $this->favicon !== null)
            return asset('storage/'.$favicon);
        else
            return asset('assets/front-clients/images/favicon.ico');
    }
}
