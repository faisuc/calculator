<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Button from '@/Components/Calculator/Button.vue';

const expression = ref('0');
const tickerTapes = ref([]);
const equalsOperationTriggered = ref(false);

const getTickerTapes = async () => {
    let response = await axios.get('/api/ticker_tapes');
    tickerTapes.value = response.data.data;
}

const deleteTickerTape = async (id) => {
    await axios.delete(`/api/ticker_tapes/${id}`)
        .then(response => {
            tickerTapes.value = tickerTapes.value.filter((item) => {
                return item.id != id;
            })
        });
};

const deleteAllTickerTapes = async() => {
    await axios.delete('/api/ticker_tapes/delete-all')
        .then(response => {
            tickerTapes.value = [];
        });
}

const calculate = async () => {
    await axios.post('/api/calculator', { expression: expression.value })
        .then(response => {
            expression.value = response.data.answer;

            tickerTapes.value.unshift({
                id: response.data.id,
                expression: response.data.expression,
                answer: response.data.answer,
            });

            equalsOperationTriggered.value = true;
        })
        .catch(error => {
            expression.value = 'Invalid input';
        });
}

function inputValue(value) {
    if (equalsOperationTriggered.value) {
        expression.value = '';
        equalsOperationTriggered.value = false;
    }

    if (expression.value.toString().indexOf('0') == 0) {
        expression.value = expression.value.toString().slice(0, -1);
    }

    expression.value += value.toString();
}

function inputOperator(operator) {
    const lastNum = expression.value.match(/[0-9]+$/);

    if (operator == 'exp') {
        let exp = prompt("Please enter exponent value", 2);

        if (exp) {
            if (lastNum !== null) {
                expression.value = Math.pow(lastNum[0], exp);
            } else {
                expression.value = Math.pow(eval(expression.value), exp);
            }
        }
    } else if (operator == 'sqrt') {
        if (lastNum !== null) {
            expression.value = Math.sqrt(lastNum[0]);
        } else {
            expression.value = Math.sqrt(eval(expression.value));
        }
    }
}

function clearEntry() {
    expression.value = '0';
}

function deleteEntry() {
    expression.value = expression.value.substring(0, expression.value.length - 1);

    if (expression.value.length == 0) {
        expression.value = '0';
    }
}

onMounted(getTickerTapes);
</script>

<template>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 py-16 px-4 sm:px-6 lg:px-8 lg:py-24">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-200 sm:text-4xl">
                    Calculator
                </h2>
            </div>
            <div class="relative mx-auto flex space-x-5">
                <div class="w-1/2">
                    <div class="w-full mb-5 p-5 border-2 border-green-70 text-right font-bold">
                        <p class="font-base text-5xl align-center">{{ expression }}</p>
                    </div>

                    <div class="grid grid-cols-4 gap-1 grid-cols">
                        <Button @click="inputOperator('exp')">EXP</Button>
                        <Button @click="clearEntry">CE</Button>
                        <Button @click="clearEntry">C</Button>
                        <Button @click="deleteEntry">DEL</Button>
                        <Button @click="inputValue('(')">(</Button>
                        <Button @click="inputValue(')')">)</Button>
                        <Button @click="inputOperator('sqrt')">2√x</Button>
                        <Button @click="inputValue('/')">/</Button>
                        <Button @click="inputValue(7)">7</Button>
                        <Button @click="inputValue(8)">8</Button>
                        <Button @click="inputValue(9)">9</Button>
                        <Button @click="inputValue('*')">X</Button>
                        <Button @click="inputValue(4)">4</Button>
                        <Button @click="inputValue(5)">5</Button>
                        <Button @click="inputValue(6)">6</Button>
                        <Button @click="inputValue('-')">-</Button>
                        <Button @click="inputValue(1)">1</Button>
                        <Button @click="inputValue(2)">2</Button>
                        <Button @click="inputValue(3)">3</Button>
                        <Button @click="inputValue('+')">+</Button>
                        <Button>+/-</Button>
                        <Button @click="inputValue(0)">0</Button>
                        <Button @click="inputValue('.')">.</Button>
                        <Button @click="calculate">=</Button>
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="flex space-between">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 min-w-0 flex-1">History</h2>
                        <a v-if="(tickerTapes.length > 0)"
                            @click="deleteAllTickerTapes"
                            href="#"
                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Delete All</a>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200 h-96 overflow-y-scroll mt-5">
                        <template v-for="item in tickerTapes" :key="item.id">
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-lg font-medium text-gray-900">
                                            {{ item.expression }} {{ item.answer ? ' = ' + item.answer : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="#"
                                            @click.prevent="deleteTickerTape(item.id)"
                                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Delete</a>
                                    </div>
                                </div>
                            </li>
                        </template>
                        <li v-if="(tickerTapes.length == 0)" class="flex py-4">
                            <div>
                                <p class="text-lg font-bold text-gray-900">
                                    No history
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>