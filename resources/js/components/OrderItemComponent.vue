<template>
    <div class="order-item" :class="statusClass(order.status)">
        <div class="order-item__block">Order Number: {{ order.order_number }}</div>
        <div class="order-item__block">Date: {{ order.order_date }}</div>
        <div class="order-item__block">Customer: {{ order.customer_first_name }} {{ order.customer_middle_name }} {{ order.customer_last_name }}</div>
        <div class="order-item__block">Total: {{ order.total_amount }}</div>
        <div :class="statusClass(order.status)" class="order-item__block status-text" >
            Status: {{ order.status }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        order: {
            type: Object,
            required: true
        }
    },
    methods:{
        statusClass(status) {
            // Преобразование статуса в класс для стилизации
            const statusLowerCase = status.toLowerCase();
            switch (statusLowerCase) {
                case 'new':
                    return 'status-new';
                case 'processing':
                    return 'status-processing';
                case 'shipped':
                    return 'status-shipped';
                default:
                    return '';
            }
        }
    }
};
</script>

<style scoped>
.order-item {
    border: 1px solid #e1e4e8;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    transition: box-shadow 0.3s ease-in-out;
    display: flex;
    flex-wrap: wrap;
}

.order-item__block{
    width: 50%;
}

.order-item:hover {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.status-new {
    background-color: #cffaf4;
    .status-text {
        color: #38c172;
    }
}

.status-processing {
    background-color: #fffbea;
    .status-text {
        color: #dac50b;
    }
}

.status-shipped {
    background-color: #e0e8ff;
    .status-text {
        color: #3490dc;
    }
}
</style>
