<template>
    <div class="order-list">
        <div class="order-list-controls">
            <button @click="sortOrders">Сортировать по цене {{sortAscending? '↑':'↓'}}</button>
            <select v-model="selectedStatus" @change="fetchOrders">
                <option value="">Все статусы</option>
                <option value="new">Новый</option>
                <option value="processing">В обработке</option>
                <option value="shipped">Отправлен</option>
            </select>
        </div>
        <order-item-component
            v-for="order in filteredOrders"
            :key="order.id"
            :order="order"
        />
        <div class="pagination">
            <button @click="fetchOrders(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">Пред.</button>
            <span>Страница {{ pagination.current_page }} из {{ pagination.last_page }} </span>
            <button @click="fetchOrders(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page">След.</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import OrderItemComponent from './OrderItemComponent.vue';

export default {
    components: {
        OrderItemComponent
    },
    data() {
        return {
            orders: [],
            sortAscending: true,
            selectedStatus: '',
            filteredOrders: [],
            pagination: {},
        };
    },
    computed: {
        // Вычисляемое свойство для сортированных заказов
        sortedOrders() {
            return this.orders.sort((a, b) => {
                return this.sortAscending
                    ? a.total_amount - b.total_amount
                    : b.total_amount - a.total_amount;
            });
        }
    },
    created() {
        this.fetchOrders();
    },
    methods: {
        fetchOrders(page = 1) {
            const params = {
                page: page,
                status: this.selectedStatus,
                sort_by: 'total_amount',
                sort_direction: this.sortAscending ? 'asc' : 'desc'
            };
            axios.get(`http://127.0.0.1:8000/orders`, { params })
                .then(response => {
                    this.orders = response.data.data;
                    this.pagination = response.data;
                    this.applyFilter()
                })
                .catch(error => {
                    console.error('There was an error fetching the orders:', error);
                });
        },
        sortOrders() {
            this.sortAscending = !this.sortAscending;
            this.fetchOrders()
        },
        applyFilter() {
            if (this.selectedStatus) {
                this.filteredOrders = this.sortedOrders.filter(order => order.status.toLowerCase() === this.selectedStatus.toLowerCase());
            } else {
                this.filteredOrders = this.sortedOrders;
            }
        },
    }
};
</script>

<style scoped>
.order-list {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}
.order-list-controls {
    margin-bottom: 20px;
}
.order-list-controls select {
    padding: 10px 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: white;
    font-size: 16px;
    cursor: pointer;
}

.order-list-controls select:focus {
    outline: none;
    border-color: #3490dc;
}

.order-list-controls option {
    padding: 10px;
}
.order-list button {
    background-color: #3490dc;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-right: 12px;
}
.order-list button:disabled {
    background-color: rgba(52, 144, 220, 0.5);
}

.order-list button:hover {
    background-color: #2779bd;
}

.order-item div {
    margin-bottom: 5px;
    font-size: 14px;
}

.order-item div:first-child {
    font-weight: bold;
    color: #333;
}

.order-item div:last-child {
    padding: 5px 0;
    font-weight: bold;
}
.pagination span{
    margin-right: 12px;
}
</style>
