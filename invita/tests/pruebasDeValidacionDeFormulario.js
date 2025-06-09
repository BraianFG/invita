/**
 * Pruebas de Validación de Formulario
 * Archivo: tests/form-validation-tests.js
 */

class FormValidationTester {
    constructor() {
        this.testResults = [];
        this.form = null;
    }

    /**
     * Inicializar el entorno de pruebas
     */
    init() {
        console.log('🧪 Inicializando pruebas de validación de formulario...');

        // Crear formulario de prueba en memoria
        this.createTestForm();

        // Ejecutar todas las pruebas
        this.runAllTests();

        // Mostrar resultados
        this.displayResults();
    }

    /**
     * Crear formulario de prueba
     */
    createTestForm() {
        // Simulamos el formulario del DOM
        this.form = {
            fecha: { value: '', required: true },
            hora: { value: '', required: true },
            direccion: { value: '', required: true },
            evento: { value: '', required: true },
            otroEvento: { value: '', required: false },
            mensaje: { value: '', required: true },
            nombre: { value: '', required: true },
            imagen: { files: [], required: true },
            modelo: { value: 'modelo1', required: true }
        };
    }

    /**
     * Ejecutar todas las pruebas
     */
    runAllTests() {
        console.log('📋 Ejecutando pruebas de validación...\n');

        this.testRequiredFields();
        this.testDateValidation();
        this.testTimeValidation();
        this.testEventTypeValidation();
        this.testFileValidation();
        this.testModelSelection();
        this.testFormSubmission();
        this.testConditionalFields();
        this.testSanitization();
    }

    /**
     * Prueba de campos requeridos
     */
    testRequiredFields() {
        console.log('🔍 Probando campos requeridos...');

        const requiredFields = ['fecha', 'hora', 'direccion', 'evento', 'mensaje', 'nombre'];

        // Probar con campos vacíos
        requiredFields.forEach(field => {
            this.form[field].value = '';
            const isValid = this.validateField(field);
            this.addResult('Campos Requeridos', `${field} vacío`, !isValid,
                          `El campo ${field} debe ser requerido`);
        });

        // Probar con campos llenos
        const testData = {
            fecha: '2024-12-25',
            hora: '18:00',
            direccion: 'Av. Corrientes 1234',
            evento: 'boda',
            mensaje: 'Te esperamos en nuestra celebración',
            nombre: 'Juan Pérez'
        };

        Object.keys(testData).forEach(field => {
            this.form[field].value = testData[field];
            const isValid = this.validateField(field);
            this.addResult('Campos Requeridos', `${field} con datos`, isValid,
                          `El campo ${field} debe ser válido con datos correctos`);
        });
    }

    /**
     * Prueba de validación de fecha
     */
    testDateValidation() {
        console.log('📅 Probando validación de fecha...');

        const testCases = [
            { value: '2024-12-25', expected: true, desc: 'Fecha válida futura' },
            { value: '2020-01-01', expected: false, desc: 'Fecha pasada' },
            { value: '', expected: false, desc: 'Fecha vacía' },
            { value: 'invalid-date', expected: false, desc: 'Formato inválido' },
            { value: '2024-13-01', expected: false, desc: 'Mes inválido' },
            { value: '2024-02-30', expected: false, desc: 'Día inválido' }
        ];

        testCases.forEach(testCase => {
            this.form.fecha.value = testCase.value;
            const isValid = this.validateDate(testCase.value);
            this.addResult('Validación Fecha', testCase.desc,
                          isValid === testCase.expected,
                          `Fecha: ${testCase.value}`);
        });
    }

    /**
     * Prueba de validación de hora
     */
    testTimeValidation() {
        console.log('🕐 Probando validación de hora...');

        const testCases = [
            { value: '14:30', expected: true, desc: 'Hora válida' },
            { value: '00:00', expected: true, desc: 'Medianoche' },
            { value: '23:59', expected: true, desc: 'Fin del día' },
            { value: '25:00', expected: false, desc: 'Hora inválida' },
            { value: '12:60', expected: false, desc: 'Minutos inválidos' },
            { value: '', expected: false, desc: 'Hora vacía' }
        ];

        testCases.forEach(testCase => {
            this.form.hora.value = testCase.value;
            const isValid = this.validateTime(testCase.value);
            this.addResult('Validación Hora', testCase.desc,
                          isValid === testCase.expected,
                          `Hora: ${testCase.value}`);
        });
    }

    /**
     * Prueba de validación de tipo de evento
     */
    testEventTypeValidation() {
        console.log('🎉 Probando validación de tipo de evento...');

        const validEvents = ['boda', 'cumpleaños', 'baby_shower', 'bautismo', 'Quince', 'otro'];

        validEvents.forEach(event => {
            this.form.evento.value = event;
            const isValid = this.validateEventType(event);
            this.addResult('Tipo de Evento', `Evento ${event}`, isValid,
                          `Tipo de evento válido: ${event}`);
        });

        // Probar evento inválido
        this.form.evento.value = 'evento_inexistente';
        const isInvalid = !this.validateEventType('evento_inexistente');
        this.addResult('Tipo de Evento', 'Evento inválido', isInvalid,
                      'Debe rechazar eventos no válidos');
    }

    /**
     * Prueba de validación de archivos
     */
    testFileValidation() {
        console.log('📁 Probando validación de archivos...');

        const testFiles = [
            { name: 'imagen.jpg', type: 'image/jpeg', size: 1024000, expected: true },
            { name: 'imagen.png', type: 'image/png', size: 512000, expected: true },
            { name: 'imagen.gif', type: 'image/gif', size: 256000, expected: true },
            { name: 'documento.pdf', type: 'application/pdf', size: 1024, expected: false },
            { name: 'imagen.jpg', type: 'image/jpeg', size: 10240000, expected: false }, // Muy grande
            { name: 'imagen.bmp', type: 'image/bmp', size: 1024, expected: false } // Tipo no permitido
        ];

        testFiles.forEach(file => {
            const isValid = this.validateFile(file);
            this.addResult('Validación Archivo',
                          `${file.name} (${file.type})`,
                          isValid === file.expected,
                          `Archivo: ${file.name}, Tamaño: ${file.size} bytes`);
        });
    }

    /**
     * Prueba de selección de modelo
     */
    testModelSelection() {
        console.log('🎨 Probando selección de modelo...');

        const validModels = ['modelo1', 'modelo2', 'modelo3'];

        validModels.forEach(model => {
            this.form.modelo.value = model;
            const isValid = this.validateModel(model);
            this.addResult('Selección Modelo', `Modelo ${model}`, isValid,
                          `Modelo válido: ${model}`);
        });

        // Probar modelo inválido
        this.form.modelo.value = 'modelo_inexistente';
        const isInvalid = !this.validateModel('modelo_inexistente');
        this.addResult('Selección Modelo', 'Modelo inválido', isInvalid,
                      'Debe rechazar modelos no válidos');
    }

    /**
     * Prueba de envío de formulario
     */
    testFormSubmission() {
        console.log('📤 Probando envío de formulario...');

        // Datos válidos completos
        const validData = {
            fecha: '2024-12-25',
            hora: '18:00',
            direccion: 'Av. Corrientes 1234, Buenos Aires',
            evento: 'boda',
            mensaje: 'Te esperamos en nuestra boda',
            nombre: 'Juan y María',
            modelo: 'modelo1'
        };

        // Llenar formulario con datos válidos
        Object.keys(validData).forEach(key => {
            this.form[key].value = validData[key];
        });

        const isFormValid = this.validateForm();
        this.addResult('Envío Formulario', 'Formulario válido completo', isFormValid,
                      'Formulario con todos los datos válidos debe pasar validación');

        // Probar formulario incompleto
        this.form.nombre.value = '';
        const isFormInvalid = !this.validateForm();
        this.addResult('Envío Formulario', 'Formulario incompleto', isFormInvalid,
                      'Formulario incompleto debe fallar validación');
    }

    /**
     * Prueba de campos condicionales
     */
    testConditionalFields() {
        console.log('🔄 Probando campos condicionales...');

        // Cuando evento es "otro", otroEvento debe ser requerido
        this.form.evento.value = 'otro';
        this.form.otroEvento.value = '';

        const requiresOtherEvent = this.validateConditionalFields();
        this.addResult('Campos Condicionales', 'Otro evento requerido', !requiresOtherEvent,
                      'Cuando evento es "otro", otroEvento debe ser requerido');

        // Con otroEvento lleno
        this.form.otroEvento.value = 'Graduación';
        const validWithOtherEvent = this.validateConditionalFields();
        this.addResult('Campos Condicionales', 'Otro evento válido', validWithOtherEvent,
                      'Con otroEvento lleno debe ser válido');

        // Cuando evento no es "otro", otroEvento no es requerido
        this.form.evento.value = 'boda';
        this.form.otroEvento.value = '';
        const notRequiredWhenNotOther = this.validateConditionalFields();
        this.addResult('Campos Condicionales', 'Otro evento no requerido', notRequiredWhenNotOther,
                      'Cuando evento no es "otro", otroEvento no debe ser requerido');
    }

    /**
     * Prueba de sanitización de datos
     */
    testSanitization() {
        console.log('🧼 Probando sanitización de datos...');

        const testCases = [
            {
                input: '<script>alert("hack")</script>Juan',
                field: 'nombre',
                desc: 'Script injection en nombre'
            },
            {
                input: 'Mensaje con <b>HTML</b> tags',
                field: 'mensaje',
                desc: 'HTML tags en mensaje'
            },
            {
                input: "'; DROP TABLE users; --",
                field: 'direccion',
                desc: 'SQL injection en dirección'
            }
        ];

        testCases.forEach(testCase => {
            const sanitized = this.sanitizeInput(testCase.input);
            const isSafe = !this.containsDangerousContent(sanitized);
            this.addResult('Sanitización', testCase.desc, isSafe,
                          `Input: ${testCase.input} -> Sanitized: ${sanitized}`);
        });
    }

    // MÉTODOS DE VALIDACIÓN

    validateField(fieldName) {
        const field = this.form[fieldName];
        if (!field) return false;

        if (field.required && (!field.value || field.value.trim() === '')) {
            return false;
        }

        return true;
    }

    validateDate(dateString) {
        if (!dateString) return false;

        const date = new Date(dateString);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        return date instanceof Date &&
               !isNaN(date.getTime()) &&
               date >= today;
    }

    validateTime(timeString) {
        if (!timeString) return false;

        const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
        return timeRegex.test(timeString);
    }

    validateEventType(eventType) {
        const validEvents = ['boda', 'cumpleaños', 'baby_shower', 'bautismo', 'Quince', 'otro'];
        return validEvents.includes(eventType);
    }

    validateFile(file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        return validTypes.includes(file.type) && file.size <= maxSize;
    }

    validateModel(model) {
        const validModels = ['modelo1', 'modelo2', 'modelo3'];
        return validModels.includes(model);
    }

    validateForm() {
        const requiredFields = ['fecha', 'hora', 'direccion', 'evento', 'mensaje', 'nombre'];

        for (let field of requiredFields) {
            if (!this.validateField(field)) {
                return false;
            }
        }

        return this.validateConditionalFields();
    }

    validateConditionalFields() {
        if (this.form.evento.value === 'otro') {
            return this.form.otroEvento.value.trim() !== '';
        }
        return true;
    }

    sanitizeInput(input) {
        return input
            .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
            .replace(/<[^>]*>/g, '')
            .replace(/['"]/g, '')
            .trim();
    }

    containsDangerousContent(input) {
        const dangerous = [
            /<script/i,
            /javascript:/i,
            /on\w+\s*=/i,
            /drop\s+table/i,
            /union\s+select/i,
            /insert\s+into/i
        ];

        return dangerous.some(pattern => pattern.test(input));
    }

    // MÉTODOS AUXILIARES

    addResult(category, test, passed, message = '') {
        this.testResults.push({
            category,
            test,
            passed,
            message,
            timestamp: new Date().toISOString()
        });
    }

    displayResults() {
        console.log('\n📊 RESULTADOS DE VALIDACIÓN');
        console.log('=' .repeat(50));

        // Agrupar resultados por categoría
        const groupedResults = this.testResults.reduce((acc, result) => {
            if (!acc[result.category]) {
                acc[result.category] = [];
            }
            acc[result.category].push(result);
            return acc;
        }, {});

        let totalTests = 0;
        let passedTests = 0;

        // Mostrar resultados por categoría
        Object.keys(groupedResults).forEach(category => {
            console.log(`\n📋 ${category}`);
            console.log('-'.repeat(30));

            groupedResults[category].forEach(result => {
                const status = result.passed ? '✅ PASS' : '❌ FAIL';
                console.log(`${status} - ${result.test}`);
                if (result.message) {
                    console.log(`   💡 ${result.message}`);
                }
                totalTests++;
                if (result.passed) passedTests++;
            });
        });

        // Resumen final
        console.log('\n📈 RESUMEN FINAL');
        console.log('=' .repeat(30));
        console.log(`Total de pruebas: ${totalTests}`);
        console.log(`Pruebas pasadas: ${passedTests}`);
        console.log(`Pruebas fallidas: ${totalTests - passedTests}`);
        console.log(`Porcentaje de éxito: ${((passedTests / totalTests) * 100).toFixed(2)}%`);

        if (passedTests === totalTests) {
            console.log('\n🎉 ¡Todas las pruebas pasaron exitosamente!');
        } else {
            console.log('\n⚠️ Algunas pruebas fallaron. Revisar implementación.');
        }
    }
}

// Ejecutar las pruebas
const tester = new FormValidationTester();
tester.init();
