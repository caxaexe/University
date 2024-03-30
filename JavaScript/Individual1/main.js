class TransactionAnalyzer {
    
    /**
     * Initialize TransactionAnalyzer with transactions array.
     * @param {Array<Object>} transactions - Array of transaction objects.
     */
    constructor(transactions) {
        this.transactions = transactions;
    }

    /**
     * Add a transaction to the transactions array.
     * @param {Object} transaction - Transaction object to be added.
     */
    addTransaction(transaction) {
        this.transactions.push(transaction);
    }

    /**
     * Retrieve all transactions.
     * @returns {Array<Object>} Array of all transactions.
     */
    getAllTransactions() {
        return this.transactions;
    }

    /**
     * Get unique transaction types.
     * @returns {Array<string>} Array of unique transaction types.
     */
    getUniqueTransactionType() {
    const types = new Set(this.transactions.map(transaction => transaction.transaction_type)); // map извлекает типы из каждого объекта, set удаляет дубликаты и определяет уникальные значения
    return Array.from(types); // преобразует объект set types обратно в массив
    }

    /**
     * Calculate total amount of all transactions.
     * @returns {number} Total amount of all transactions.
     */
    calculateTotalAmount() {
        return this.transactions.reduce((total, transaction) => total + transaction.transaction_amount, 0); // reduce обрабатывает массив и сводит его к одному значению
    }

    /**
     * Calculate total amount of transactions on a specific date.
     * @param {number} year - Year.
     * @param {number} month - Month (1-12).
     * @param {number} day - Day of the month.
     * @returns {number} Total amount of transactions on the specified date.
     */
    calculateTotalAmountByDate(year, month, day) {
        let totalAmount = 0;
        for (const transaction of this.transactions) { // позволяет перебирать каждую транзакцию
            const transactionDate = new Date(transaction.transaction_date); // создаю объект Date, чтобы преобразовать строку ..._date в объект даты для сравнения с заданной датой
            if (
                transactionDate.getFullYear() === year && // проверка соответствует ли дата транзакции заданной
                transactionDate.getMonth() === month - 1 && // -1 тк начинается с 0
                transactionDate.getDate() === day
            ) {
                totalAmount += transaction.transaction_amount; // если проверка прошла, то + к общей сумме totalAmount
            }
        }
        return totalAmount;
    }
      
    /**
     * Get transactions by transaction type.
     * @param {string} type - Transaction type to filter by.
     * @returns {Array<Object>} Array of transactions with the specified type.
     */
    getTransactionByType(type) {
        return this.transactions.filter(t => t.transaction_type === type); // filter создает новый массив с элементами, прошедшими проверку, t представляет каждый элемент массива
    }

    /**
     * Get transactions within a specified date range.
     * @param {string} startDate - Start date of the range.
     * @param {string} endDate - End date of the range.
     * @returns {Array<Object>} Array of transactions within the specified date range.
     */
    getTransactionsInDateRange(startDate, endDate) {
        const start = new Date(startDate); // создаются два объекта, Date интерпретирует вводимые данные, как допустимую дату
        const end = new Date(endDate);
        return this.transactions.filter(t => { // filter перебирает каждый элемент t в массиве и сохраняет только те, которые подходят под true
            const date = new Date(t.transaction_date); // извлекается часть даты из данных транзакций в date
            return date >= start && date <= end; // проверка дат
        });
    }

    /**
     * Get transactions by merchant name.
     * @param {string} merchantName - Name of the merchant to filter by.
     * @returns {Array<Object>} Array of transactions from the specified merchant.
     */
    getTransactionsByMerchant(merchantName) {
        return this.transactions.filter(t => t.merchant_name === merchantName); // проверка совпадают ли вводимые данные с данными из тразакций
    }

    /**
     * Calculate average transaction amount.
     * @returns {number} Average transaction amount.
     */
    calculateAverageTransactionAmount() {
        return this.calculateTotalAmount() / this.transactions.length; // делит общую сумму всех транзакций на количество транзакций и определяет среднюю сумму транзакций
    }

    /**
     * Get transactions within a specified amount range.
     * @param {number} minAmount - Minimum transaction amount.
     * @param {number} maxAmount - Maximum transaction amount.
     * @returns {Array<Object>} Array of transactions within the specified amount range.
     */
    getTransactionsByAmountRange(minAmount, maxAmount) {
        return this.transactions.filter(t => t.transaction_amount >= minAmount && t.transaction_amount <= maxAmount); // определяет соответствие минимума и максимума с данными из транзакции (t_amount)
    }

    /**
     * Calculate total debit amount.
     * @returns {number} Total debit amount.
     */
    calculateTotalDebitAmount() {
        return this.getTransactionByType("debit").reduce((sum, t) => sum + t.transaction_amount, 0); // sum накапливает итоговую сумму и к ней прибавляется каждую итерацию текущая сумма транзакции
        // reduce сжимает весь массив дебетовых транзакций в одно значение
    }

    /**
     * Find the month with the most transactions.
     * @returns {number} The month index with the most transactions (0-11).
     */
    findMostTransactionsMonth() {
        const counts = {}; // пустой объект-счетчик
        for (const t of this.transactions) {
            const month = new Date(t.transaction_date).getMonth(); // в month извлекается месяц из t_date, а метод getMonth получает месяц от 0 (янв) до 11 (дек)
            counts[month] = (counts[month] || 0) + 1; // обращение к ключу month из counts, если counts[month] равен undefined, возвращает 0, если наоборот, то содержмое counts[month]
            // +1 увеличивает значение счетчика на 1 для данного month
        }
        return Object.keys(counts).reduce((a, b) => (counts[a] > counts[b] ? a : b)); // object.keys преобразует объект counts в массив его ключей (месяцев), reduce последовательно сравнивает месяца и определяет с наибольшим количеством транзакций
        // ? сравнивается колво текущего месяца(а) и следующего (b), если true, то возвращает месяц а, если false, то b
    }

    /**
     * Find the month with the most debit transactions.
     * @returns {number} The month index with the most debit transactions (0-11).
     */
    findMostDebitTransactionMonth() {
        const counts = {};
        for (const t of this.getTransactionByType("debit")) {
            const month = new Date(t.transaction_date).getMonth();
            counts[month] = (counts[month] || 0) + 1;
        }
        return Object.keys(counts).reduce((a, b) => (counts[a] > counts[b] ? a : b));
    }

    /**
     * Find the most common transaction type.
     * @returns {string} The most common transaction type.
     */
    mostTransactionTypes() {
        const typeCounts = {}; // объект-счетчик
        for (const t of this.transactions) {
            if (typeCounts[t.transaction_type]) { // если счетчик для этого типа транзакции уже есть, то увеличивается на один
                typeCounts[t.transaction_type]++;
            } else { // если счетчика нет, то устанавливается значение 1
                typeCounts[t.transaction_type] = 1;
            }
        }
        const types = Object.keys(typeCounts); // ключи счетчика сохраняются в массив types 
        if (types.length === 1) { 
            return types[0];
        } else {
            let mostCommonType = types[0]; // mostCommonType храненит тип транзакции с наибольшим количеством на данный момент и принимает значение первого элемента массива
            for (const type of types) { 
                if (typeCounts[type] > typeCounts[mostCommonType]) {
                    mostCommonType = type; // если количество транзакций для текущего типа (type) больше, чем для текущего типа с наибольшим количеством (mostCommonType), то переменная mostCommonType обновляется на этот тип
                }
            }
            return mostCommonType;
        }
    }
    
    /**
     * Get transactions before a specified date.
     * @param {string} date - Date to compare against.
     * @returns {Array<Object>} Array of transactions before the specified date.
     */
    getTransactionsBeforeDate(date) {
        const data = new Date(date); // вводимые данные date преобразуются в data
        return this.transactions.filter(t => new Date(t.transaction_date) < data); // filter сохраняет только те элементы, которые равны true, тут те, которые меньше data
    }

    /**
     * Find a transaction by its ID.
     * @param {string} id - ID of the transaction to find.
     * @returns {Object|null} Transaction object if found, otherwise null.
     */
    findTransactionById(id) {
        return this.transactions.find((t) => t.transaction_id == id); // find ищет и возвращает первый элемент в массиве, где t_id равен true
    }

    /**
     * Map transaction descriptions.
     * @returns {Array<string>} Array of transaction descriptions.
     */
    mapTransactionDescriptions() {
        return this.transactions.map(t => t.transaction_description); // map позволяет применить эту функцию для каждого элемента массива и возвращает измененный массив
    }
}


const transactions = require('./transaction.json'); // импорт
const analyzer = new TransactionAnalyzer(transactions); // создание экземпляра класса с транзакциями

// первый метод - тип транзакции
// console.log(analyzer.getUniqueTransactionType());

// второй метод - общая сумма всех транзакций
// console.log(analyzer.calculateTotalAmount());

// третий метод - общая сумма транзакций за год, месяц, день
// console.log(analyzer.calculateTotalAmountByDate()); // (yyyy, m, d)

// четвертый метод - транзакции указанного типа
// console.log(analyzer.getTransactionByType('credit'));

// пятый метод - транзакции в определенный период от - до
// console.log(analyzer.getTransactionsInDateRange()); // ('yyyy, m,, d', 'yyyy, m, d'), исключая второй элемент

// шестой метод - транзакции с указанным рабочим местом
// console.log(analyzer.getTransactionsByMerchant());

// седьмой метод - среднее значение транзакций
// console.log(analyzer.calculateAverageTransactionAmount());

// восьмой метод - транзакции с суммой от мин до макс
// console.log(analyzer.getTransactionsByAmountRange()); // min, max

// девятый метод - сумма дебетовых транзакций
// console.log(analyzer.calculateTotalDebitAmount());

// десятый метод - месяц, в котором больше траназакций
// console.log(analyzer.findMostTransactionsMonth());

// одиннадцатый метод - месяц, в котором больше дебетовых транзакций
// console.log(analyzer.findMostDebitTransactionMonth());

// двенадцатый метод - каких транзакций больше (дебетовых, кредитовых, одинаковы)
// console.log(analyzer.mostTransactionTypes());

// тринадцатый метод - транзакции до указазанной даты
// console.log(analyzer.getTransactionsBeforeDate()); // ('yyyy, m, d')

// четырнадцатый метод - поиск траназкций по айди
// console.log(analyzer.findTransactionById());

// пятнадцатый метод - описание
// console.log(analyzer.mapTransactionDescriptions());