<template>
    <div>
        <Head title="StoreProduct" />
        <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                商品管理
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto max-w-6xl space-y-6 sm:px-6 lg:px-8">
                <!-- 商品管理標籤 -->
                <a-tabs v-model="activeTabKey">
                    <a-tab-pane key="products" tab="房型上架">
                        <div class="mb-4 flex justify-end">
                            <a-button type="primary" @click="showProductModal">新增商品</a-button>
                        </div>
                        
                        <a-table :dataSource="products" :columns="productColumns" rowKey="id">
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'price'">
                                    {{ record.price.toFixed(2) }}
                                </template>
                                <template v-if="column.key === 'status'">
                                    <a-tag :color="record.status ? 'green' : 'red'">
                                        {{ record.status ? '上架中' : '已下架' }}
                                    </a-tag>
                                </template>
                                <template v-if="column.key === 'actions'">
                                    <a-button type="link" @click="editProduct(record)">編輯</a-button>
                                    <a-button type="link" @click="manageProductImages(record)">管理圖片</a-button>
                                    <a-popconfirm
                                        title="確定要刪除此商品嗎?"
                                        @confirm="deleteProduct(record.id)"
                                        okText="確定"
                                        cancelText="取消"
                                    >
                                        <a-button type="link" danger>刪除</a-button>
                                    </a-popconfirm>
                                </template>
                            </template>
                        </a-table>
                    </a-tab-pane>
                    
                    <a-tab-pane key="banners" tab="首頁廣告管理">
                        <div class="mb-4 flex justify-end">
                            <a-button type="primary" @click="showBannerModal">新增廣告</a-button>
                        </div>
                        
                        <a-table :dataSource="banners" :columns="bannerColumns" rowKey="id">
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'image'">
                                    <img :src="record.image_url" alt="廣告圖片" class="w-32 h-20 object-cover" />
                                </template>
                                <template v-if="column.key === 'is_active'">
                                    <a-tag :color="record.is_active ? 'green' : 'red'">
                                        {{ record.is_active ? '啟用中' : '已停用' }}
                                    </a-tag>
                                </template>
                                <template v-if="column.key === 'actions'">
                                    <a-button type="link" @click="editBanner(record)">編輯</a-button>
                                    <a-popconfirm
                                        title="確定要刪除此廣告嗎?"
                                        @confirm="deleteBanner(record.id)"
                                        okText="確定"
                                        cancelText="取消"
                                    >
                                        <a-button type="link" danger>刪除</a-button>
                                    </a-popconfirm>
                                </template>
                            </template>
                        </a-table>
                    </a-tab-pane>
                    
                    <a-tab-pane key="promotions" tab="宣傳活動管理">
                        <div class="mb-4 flex justify-end">
                            <a-button type="primary" @click="showPromotionModal">新增活動</a-button>
                        </div>
                        
                        <a-table :dataSource="promotions" :columns="promotionColumns" rowKey="id">
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'image'">
                                    <img :src="record.image_url" alt="活動圖片" class="w-32 h-20 object-cover" />
                                </template>
                                <template v-if="column.key === 'is_active'">
                                    <a-tag :color="record.is_active ? 'green' : 'red'">
                                        {{ record.is_active ? '啟用中' : '已停用' }}
                                    </a-tag>
                                </template>
                                <template v-if="column.key === 'actions'">
                                    <a-button type="link" @click="editPromotion(record)">編輯</a-button>
                                    <a-popconfirm
                                        title="確定要刪除此活動嗎?"
                                        @confirm="deletePromotion(record.id)"
                                        okText="確定"
                                        cancelText="取消"
                                    >
                                        <a-button type="link" danger>刪除</a-button>
                                    </a-popconfirm>
                                </template>
                            </template>
                        </a-table>
                    </a-tab-pane>
                </a-tabs>
            </div>
        </div>
        </AuthenticatedLayout>

        <!-- 商品表單彈窗 -->
        <a-modal
            v-model="productModalVisible"
            :title="editingProductId ? '編輯商品' : '新增商品'"
            @ok="submitProductForm"
            :confirmLoading="submitLoading"
        >
            <a-form :model="productForm" :label-col="{ span: 6 }" :wrapper-col="{ span: 18 }">
                <a-form-item label="商品名稱" name="name">
                    <a-input v-model="productForm.name" />
                </a-form-item>
                <a-form-item label="商品價格" name="price">
                    <a-input-number v-model="productForm.price" style="width: 100%" />
                </a-form-item>
                <a-form-item label="商品描述" name="description">
                    <a-textarea v-model="productForm.description" :rows="4" />
                </a-form-item>
                <a-form-item label="狀態" name="status">
                    <a-switch v-model="productForm.status" />
                </a-form-item>
            </a-form>
        </a-modal>
        
        <!-- 廣告表單彈窗 -->
        <a-modal
            v-model="bannerModalVisible"
            :title="editingBannerId ? '編輯廣告' : '新增廣告'"
            @ok="submitBannerForm"
            :confirmLoading="submitLoading"
        >
            <a-form :model="bannerForm" :label-col="{ span: 6 }" :wrapper-col="{ span: 18 }">
                <a-form-item label="廣告標題" name="title">
                    <a-input v-model="bannerForm.title" />
                </a-form-item>
                <a-form-item label="廣告描述" name="description">
                    <a-textarea v-model="bannerForm.description" :rows="3" />
                </a-form-item>
                <a-form-item label="連結網址" name="link_url">
                    <a-input v-model="bannerForm.link_url" />
                </a-form-item>
                <a-form-item label="廣告圖片" name="image">
                    <a-upload
                        name="image"
                        :customRequest="handleBannerImageUpload"
                        :showUploadList="false"
                    >
                        <a-button>選擇圖片</a-button>
                    </a-upload>
                    <div v-if="bannerForm.image_url" class="mt-2">
                        <img :src="bannerForm.image_url" alt="廣告圖片預覽" class="w-full max-h-40 object-contain" />
                    </div>
                </a-form-item>
                <a-form-item label="顯示位置" name="position">
                    <a-select v-model="bannerForm.position">
                        <a-select-option value="home_top">首頁頂部</a-select-option>
                        <a-select-option value="home_middle">首頁中間</a-select-option>
                        <a-select-option value="sidebar">側邊欄</a-select-option>
                    </a-select>
                </a-form-item>
                <a-form-item label="排序順序" name="sort_order">
                    <a-input-number v-model="bannerForm.sort_order" style="width: 100%" />
                </a-form-item>
                <a-form-item label="啟用狀態" name="is_active">
                    <a-switch v-model="bannerForm.is_active" />
                </a-form-item>
                <a-form-item label="展示日期" name="date_range">
                    <a-range-picker v-model="bannerDateRange" />
                </a-form-item>
            </a-form>
        </a-modal>
        
        <!-- 宣傳活動表單彈窗 -->
        <a-modal
            v-model:visible="promotionModalVisible"
            :title="editingPromotionId ? '編輯活動' : '新增活動'"
            @ok="submitPromotionForm"
            :confirmLoading="submitLoading"
        >
            <a-form :model="promotionForm" :label-col="{ span: 6 }" :wrapper-col="{ span: 18 }">
                <a-form-item label="活動標題" name="title">
                    <a-input v-model:value="promotionForm.title" />
                </a-form-item>
                <a-form-item label="活動描述" name="description">
                    <a-textarea v-model:value="promotionForm.description" :rows="3" />
                </a-form-item>
                <a-form-item label="活動連結" name="link_url">
                    <a-input v-model:value="promotionForm.link_url" />
                </a-form-item>
                <a-form-item label="活動圖片" name="image">
                    <a-upload
                        name="image"
                        :customRequest="handlePromotionImageUpload"
                        :showUploadList="false"
                    >
                        <a-button>選擇圖片</a-button>
                    </a-upload>
                    <div v-if="promotionForm.image_url" class="mt-2">
                        <img :src="promotionForm.image_url" alt="活動圖片預覽" class="w-full max-h-40 object-contain" />
                    </div>
                </a-form-item>
                <a-form-item label="啟用狀態" name="is_active">
                    <a-switch v-model:checked="promotionForm.is_active" />
                </a-form-item>
                <a-form-item label="活動日期" name="date_range">
                    <a-range-picker v-model:value="promotionDateRange" />
                </a-form-item>
            </a-form>
        </a-modal>
        
        <!-- 商品圖片管理彈窗 -->
        <a-modal
            v-model:visible="productImagesModalVisible"
            title="商品圖片管理"
            width="800px"
            @ok="closeProductImagesModal"
        >
            <div v-if="currentProduct">
                <h3 class="text-lg font-medium mb-4">{{ currentProduct.name }} 的圖片</h3>
                
                <div class="mb-4">
                    <a-upload
                        name="image"
                        :customRequest="uploadProductImage"
                        :showUploadList="false"
                        class="mb-2"
                    >
                        <a-button type="primary">上傳新圖片</a-button>
                    </a-upload>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    <div v-for="image in currentProductImages" :key="image.id" class="border p-2 rounded">
                        <img :src="image.image_url" alt="商品圖片" class="w-full h-32 object-contain mb-2" />
                        <div class="flex items-center justify-between">
                            <a-switch v-model:checked="image.is_main" @change="setMainImage(image.id)" />
                            <a-popconfirm
                                title="確定要刪除此圖片嗎?"
                                @confirm="deleteProductImage(image.id)"
                                okText="確定"
                                cancelText="取消"
                            >
                                <a-button type="link" danger>刪除</a-button>
                            </a-popconfirm>
                        </div>
                        <div class="mt-2">
                            <a-input v-model:value="image.title" placeholder="圖片標題" class="mb-1" />
                            <a-button size="small" @click="updateImageTitle(image.id, image.title)">更新標題</a-button>
                        </div>
                    </div>
                </div>
            </div>
        </a-modal>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, reactive, computed } from "vue";
import { Head } from '@inertiajs/vue3';
import { Table, Modal, Form, Input, Button, Tabs, Select, Switch, Upload, Tag, InputNumber, DatePicker, Popconfirm } from 'ant-design-vue' 
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// 商品介面
interface Product {
    id: number;
    name: string;
    price: number;
    description?: string;
    status: boolean;
}

// 商品圖片介面
interface ProductImage {
    id: number;
    product_id: number;
    image_key: string;
    image_url: string;
    title: string;
    is_main: boolean;
    sort_order: number;
}

// 廣告介面
interface Banner {
    id: number;
    title: string;
    description?: string;
    image_key: string;
    image_url: string;
    link_url?: string;
    position: string;
    sort_order: number;
    is_active: boolean;
    start_date?: string;
    end_date?: string;
}

// 宣傳活動介面
interface Promotion {
    id: number;
    title: string;
    description?: string;
    image_key: string;
    image_url: string;
    link_url?: string;
    is_active: boolean;
    start_date?: string;
    end_date?: string;
}

// 標籤頁活躍鍵
const activeTabKey = ref('products');

// 商品數據
const products = ref<Product[]>([
    { id: 1, name: 'Product 1', price: 100, status: true },
    { id: 2, name: 'Product 2', price: 200, status: true },
    { id: 3, name: 'Product 3', price: 300, status: false },
]);

// 廣告數據
const banners = ref<Banner[]>([
    { id: 1, title: '春季大促', description: '春季大促銷活動', image_key: 'banners/spring_sale.jpg', image_url: 'https://via.placeholder.com/800x400', link_url: '/sale', position: 'home_top', sort_order: 1, is_active: true, start_date: '2025-04-01', end_date: '2025-04-30' },
    { id: 2, title: '新品上市', description: '新品上市活動', image_key: 'banners/new_arrival.jpg', image_url: 'https://via.placeholder.com/800x400', link_url: '/new', position: 'home_middle', sort_order: 2, is_active: true, start_date: '2025-04-15', end_date: '2025-05-15' },
]);

// 宣傳活動數據
const promotions = ref<Promotion[]>([
    { id: 1, title: '會員日', description: '會員專屬優惠', image_key: 'promotions/member_day.jpg', image_url: 'https://via.placeholder.com/600x300', link_url: '/member', is_active: true, start_date: '2025-04-25', end_date: '2025-04-27' }
]);

// 商品表格列配置
const productColumns = [
    { title: 'ID', dataIndex: 'id', key: 'id' },
    { title: '商品名稱', dataIndex: 'name', key: 'name' },
    { title: '價格', dataIndex: 'price', key: 'price' },
    { title: '狀態', dataIndex: 'status', key: 'status' },
    { title: '操作', key: 'actions' }
];

// 廣告表格列配置
const bannerColumns = [
    { title: 'ID', dataIndex: 'id', key: 'id' },
    { title: '標題', dataIndex: 'title', key: 'title' },
    { title: '圖片', key: 'image' },
    { title: '位置', dataIndex: 'position', key: 'position' },
    { title: '排序', dataIndex: 'sort_order', key: 'sort_order' },
    { title: '狀態', key: 'is_active' },
    { title: '操作', key: 'actions' }
];

// 宣傳活動表格列配置
const promotionColumns = [
    { title: 'ID', dataIndex: 'id', key: 'id' },
    { title: '標題', dataIndex: 'title', key: 'title' },
    { title: '圖片', key: 'image' },
    { title: '狀態', key: 'is_active' },
    { title: '開始日期', dataIndex: 'start_date', key: 'start_date' },
    { title: '結束日期', dataIndex: 'end_date', key: 'end_date' },
    { title: '操作', key: 'actions' }
];

// 表單相關狀態
const productModalVisible = ref(false);
const bannerModalVisible = ref(false);
const promotionModalVisible = ref(false);
const productImagesModalVisible = ref(false);
const submitLoading = ref(false);
const editingProductId = ref<number | null>(null);
const editingBannerId = ref<number | null>(null);
const editingPromotionId = ref<number | null>(null);
const currentProduct = ref<Product | null>(null);
const currentProductImages = ref<ProductImage[]>([]);
const bannerDateRange = ref<any>(null);
const promotionDateRange = ref<any>(null);

// 表單數據
const productForm = reactive<Product>({
    id: 0,
    name: '',
    price: 0,
    description: '',
    status: true
});

const bannerForm = reactive<Banner>({
    id: 0,
    title: '',
    description: '',
    image_key: '',
    image_url: '',
    link_url: '',
    position: 'home_top',
    sort_order: 1,
    is_active: true,
    start_date: '',
    end_date: ''
});

const promotionForm = reactive<Promotion>({
    id: 0,
    title: '',
    description: '',
    image_key: '',
    image_url: '',
    link_url: '',
    is_active: true,
    start_date: '',
    end_date: ''
});

// 商品相關方法
const showProductModal = () => {
    resetProductForm();
    productModalVisible.value = true;
};

const editProduct = (product: Product) => {
    Object.assign(productForm, product);
    editingProductId.value = product.id;
    productModalVisible.value = true;
};

const resetProductForm = () => {
    productForm.id = 0;
    productForm.name = '';
    productForm.price = 0;
    productForm.description = '';
    productForm.status = true;
    editingProductId.value = null;
};

const submitProductForm = () => {
    submitLoading.value = true;
    
    // 這裡應該是 API 請求，但現在模擬成功
    setTimeout(() => {
        if (editingProductId.value) {
            // 更新已有的商品
            const index = products.value.findIndex(p => p.id === editingProductId.value);
            if (index !== -1) {
                products.value[index] = { ...productForm, id: editingProductId.value };
            }
        } else {
            // 新增商品
            const newId = Math.max(...products.value.map(p => p.id), 0) + 1;
            products.value.push({ ...productForm, id: newId });
        }
        
        submitLoading.value = false;
        productModalVisible.value = false;
        resetProductForm();
    }, 1000);
};

const deleteProduct = (id: number) => {
    products.value = products.value.filter(p => p.id !== id);
};

// 商品圖片管理
const manageProductImages = (product: Product) => {
    currentProduct.value = product;
    // 這裡模擬從後端獲取商品圖片
    currentProductImages.value = [
        { id: 1, product_id: product.id, image_key: `products/${product.id}/image1.jpg`, image_url: 'https://via.placeholder.com/400x400', title: '主圖', is_main: true, sort_order: 1 },
        { id: 2, product_id: product.id, image_key: `products/${product.id}/image2.jpg`, image_url: 'https://via.placeholder.com/400x400', title: '側面圖', is_main: false, sort_order: 2 },
    ];
    productImagesModalVisible.value = true;
};

const closeProductImagesModal = () => {
    productImagesModalVisible.value = false;
    currentProduct.value = null;
    currentProductImages.value = [];
};

const uploadProductImage = (options: any) => {
    // 模擬上傳成功
    setTimeout(() => {
        const newId = Math.max(...currentProductImages.value.map(img => img.id), 0) + 1;
        const newImage: ProductImage = {
            id: newId,
            product_id: currentProduct.value!.id,
            image_key: `products/${currentProduct.value!.id}/image${newId}.jpg`,
            image_url: 'https://via.placeholder.com/400x400',
            title: '新圖片',
            is_main: false,
            sort_order: currentProductImages.value.length + 1
        };
        currentProductImages.value.push(newImage);
        options.onSuccess();
    }, 1000);
};

const setMainImage = (imageId: number) => {
    currentProductImages.value = currentProductImages.value.map(img => ({
        ...img,
        is_main: img.id === imageId
    }));
};

const deleteProductImage = (imageId: number) => {
    currentProductImages.value = currentProductImages.value.filter(img => img.id !== imageId);
};

const updateImageTitle = (imageId: number, title: string) => {
    // 模擬更新標題
    console.log(`更新圖片 ${imageId} 的標題為: ${title}`);
};

// 廣告相關方法
const showBannerModal = () => {
    resetBannerForm();
    bannerModalVisible.value = true;
};

const editBanner = (banner: Banner) => {
    Object.assign(bannerForm, banner);
    editingBannerId.value = banner.id;
    // 設置日期範圍
    if (banner.start_date && banner.end_date) {
        bannerDateRange.value = [banner.start_date, banner.end_date];
    }
    bannerModalVisible.value = true;
};

const resetBannerForm = () => {
    bannerForm.id = 0;
    bannerForm.title = '';
    bannerForm.description = '';
    bannerForm.image_key = '';
    bannerForm.image_url = '';
    bannerForm.link_url = '';
    bannerForm.position = 'home_top';
    bannerForm.sort_order = 1;
    bannerForm.is_active = true;
    bannerForm.start_date = '';
    bannerForm.end_date = '';
    bannerDateRange.value = null;
    editingBannerId.value = null;
};

const handleBannerImageUpload = (options: any) => {
    // 模擬上傳到 S3
    setTimeout(() => {
        bannerForm.image_key = `banners/new_banner_${Date.now()}.jpg`;
        bannerForm.image_url = 'https://via.placeholder.com/800x400';
        options.onSuccess();
    }, 1000);
};

const submitBannerForm = () => {
    submitLoading.value = true;
    
    // 更新日期範圍
    if (bannerDateRange.value) {
        bannerForm.start_date = bannerDateRange.value[0];
        bannerForm.end_date = bannerDateRange.value[1];
    }
    
    // 模擬 API 請求
    setTimeout(() => {
        if (editingBannerId.value) {
            // 更新已有的廣告
            const index = banners.value.findIndex(b => b.id === editingBannerId.value);
            if (index !== -1) {
                banners.value[index] = { ...bannerForm, id: editingBannerId.value };
            }
        } else {
            // 新增廣告
            const newId = Math.max(...banners.value.map(b => b.id), 0) + 1;
            banners.value.push({ ...bannerForm, id: newId });
        }
        
        submitLoading.value = false;
        bannerModalVisible.value = false;
        resetBannerForm();
    }, 1000);
};

const deleteBanner = (id: number) => {
    banners.value = banners.value.filter(b => b.id !== id);
};

// 宣傳活動相關方法
const showPromotionModal = () => {
    resetPromotionForm();
    promotionModalVisible.value = true;
};

const editPromotion = (promotion: Promotion) => {
    Object.assign(promotionForm, promotion);
    editingPromotionId.value = promotion.id;
    // 設置日期範圍
    if (promotion.start_date && promotion.end_date) {
        promotionDateRange.value = [promotion.start_date, promotion.end_date];
    }
    promotionModalVisible.value = true;
};

const resetPromotionForm = () => {
    promotionForm.id = 0;
    promotionForm.title = '';
    promotionForm.description = '';
    promotionForm.image_key = '';
    promotionForm.image_url = '';
    promotionForm.link_url = '';
    promotionForm.is_active = true;
    promotionForm.start_date = '';
    promotionForm.end_date = '';
    promotionDateRange.value = null;
    editingPromotionId.value = null;
};

const handlePromotionImageUpload = (options: any) => {
    // 模擬上傳到 S3
    setTimeout(() => {
        promotionForm.image_key = `promotions/new_promotion_${Date.now()}.jpg`;
        promotionForm.image_url = 'https://via.placeholder.com/600x300';
        options.onSuccess();
    }, 1000);
};

const submitPromotionForm = () => {
    submitLoading.value = true;
    
    // 更新日期範圍
    if (promotionDateRange.value) {
        promotionForm.start_date = promotionDateRange.value[0];
        promotionForm.end_date = promotionDateRange.value[1];
    }
    
    // 模擬 API 請求
    setTimeout(() => {
        if (editingPromotionId.value) {
            // 更新已有的活動
            const index = promotions.value.findIndex(p => p.id === editingPromotionId.value);
            if (index !== -1) {
                promotions.value[index] = { ...promotionForm, id: editingPromotionId.value };
            }
        } else {
            // 新增活動
            const newId = Math.max(...promotions.value.map(p => p.id), 0) + 1;
            promotions.value.push({ ...promotionForm, id: newId });
        }
        
        submitLoading.value = false;
        promotionModalVisible.value = false;
        resetPromotionForm();
    }, 1000);
};

const deletePromotion = (id: number) => {
    promotions.value = promotions.value.filter(p => p.id !== id);
};
</script>