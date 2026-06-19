//funciones que transforman datos

import { banksImageList, brandsImageList } from "./constants.js";

export const getBankImages = (text) => {
    const imageKey = Object.keys(banksImageList).find(key => 
        text.includes(key)
    );
    return imageKey;
}

export const getBrandImages = (text) => {
    const imageKey = Object.keys(brandsImageList).find(key => 
        text.includes(key)
    );
    return imageKey;
}