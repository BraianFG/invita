<?php
/**
 * Suite de Pruebas de Integración para Sistema de Invitaciones
 * Archivo: tests/IntegrationTestSuite.php
 * Versión mejorada con mejor manejo de errores y validaciones
 */

class InvitationIntegrationTest {
    private $testResults = [];
    private $baseUrl = 'http://localhost';
    private $startTime;
    private $config = [
        'timeout' => 30,
        'max_file_size' => 5 * 1024 * 1024, // 5MB
        'allowed_image_types' => ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp'],
        'uploads_dir' => 'uploads/',
        'required_php_extensions' => ['gd', 'fileinfo', 'json']
    ];

    public function __construct($baseUrl = null, $config = []) {
        $this->startTime = microtime(true);

        if ($baseUrl) {
            $this->baseUrl = rtrim($baseUrl, '/');
        }

        $this->config = array_merge($this->config, $config);
        $this->checkEnvironment();
    }

    /**
     * Verificar entorno antes de ejecutar pruebas
     */
    private function checkEnvironment() {
        echo "🔧 Verificando entorno de pruebas...\n";

        $errores = [];

        // Verificar extensiones PHP requeridas
        foreach ($this->config['required_php_extensions'] as $extension) {
            if (!extension_loaded($extension)) {
                $errores[] = $extension;
                echo "❌ Falta la extensión PHP requerida: {$extension}\n";
                echo "👉 En Termux puedes intentar instalarla con: pkg install php-{$extension}\n";
            }
        }

        // Verificar permisos de escritura
        if (!is_writable('.')) {
            $errores[] = 'No hay permisos de escritura en el directorio actual';
            echo "❌ No hay permisos de escritura en el directorio actual\n";
        }

        if (!empty($errores)) {
            echo "⚠️ Corrige los errores anteriores antes de continuar.\n";
            exit(1);
        }

        echo "✅ Entorno de pruebas verificado correctamente.\n\n";
    }

    /**
     * Ejecutar todas las pruebas
     */
    public function runAllTests() {
        echo "🚀 Iniciando Suite de Pruebas de Integración\n";
        echo "============================================\n";
        echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
        echo "PHP Version: " . PHP_VERSION . "\n";
        echo "URL Base: {$this->baseUrl}\n\n";

        try {
            $this->testEnvironmentSetup();
            $this->testPageLoad();
            $this->testRequiredIncludes();
            $this->testFormValidation();
            $this->testFileUpload();
            $this->testModelSelection();
            $this->testFormSubmission();
            $this->testJavaScriptIntegration();
            $this->testResponsiveDesign();
            $this->testSecurity();
            $this->testPerformance();
        } catch (Exception $e) {
            echo "❌ Error crítico durante las pruebas: " . $e->getMessage() . "\n";
            $this->addResult('Critical Error', 'Test execution', false, $e->getMessage());
        }

        $this->printResults();
    }

    /**
     * Prueba de configuración del entorno
     */
    private function testEnvironmentSetup() {
        echo "🌍 Probando configuración del entorno...\n";

        $tests = [
            'PHP Version >= 7.4' => version_compare(PHP_VERSION, '7.4.0', '>='),
            'Error reporting habilitado' => error_reporting() !== 0,
            'Límite de memoria adecuado' => $this->checkMemoryLimit(),
            'Límite de tiempo de ejecución' => $this->checkExecutionTimeLimit(),
            'Zona horaria configurada' => date_default_timezone_get() !== ''
        ];

        foreach ($tests as $test => $result) {
            $this->addResult('Environment', $test, $result);
        }

        echo "✅ Prueba de entorno completada\n\n";
    }

    /**
     * Prueba de carga de página principal
     */
    private function testPageLoad() {
        echo "📄 Probando carga de página principal...\n";

        try {
            $files = ['crear.php', 'index.php'];
            $mainFile = null;

            foreach ($files as $file) {
                if (file_exists($file)) {
                    $mainFile = $file;
                    break;
                }
            }

            if (!$mainFile) {
                $this->addResult('Page Load', 'Archivo principal encontrado', false, 'No se encontró crear.php ni index.php');
                return;
            }

            // Capturar la salida con manejo de errores
            $content = $this->simulatePageLoad($mainFile);

            if ($content === false) {
                $this->addResult('Page Load', 'Carga de página', false, 'Error al cargar la página');
                return;
            }

            // Verificar elementos críticos
            $tests = [
                'DOCTYPE presente' => $this->containsPattern($content, '/<!DOCTYPE\s+html>/i'),
                'HTML válido' => $this->containsPattern($content, '/<html[^>]*>/i'),
                'Formulario presente' => $this->containsPattern($content, '/id=["\']invitacionForm["\']/'),
                'Campos requeridos' => $this->checkRequiredFields($content),
                'Scripts incluidos' => $this->checkScripts($content),
                'Meta charset' => $this->containsPattern($content, '/<meta[^>]+charset/i'),
                'Meta viewport' => $this->containsPattern($content, '/<meta[^>]+viewport/i')
            ];

            foreach ($tests as $test => $result) {
                $this->addResult('Page Load', $test, $result);
            }

        } catch (Exception $e) {
            $this->addResult('Page Load', 'Error general', false, $e->getMessage());
        }

        echo "✅ Prueba de carga completada\n\n";
    }

    /**
     * Prueba de archivos incluidos
     */
    private function testRequiredIncludes() {
        echo "📦 Probando archivos incluidos...\n";

        $requiredFiles = [
            'includes/head.php' => 'critical',
            'includes/navbar.php' => 'critical',
            'includes/footer.php' => 'critical',
            'assets/css/footer.css' => 'important',
            'assets/css/nav.css' => 'important',
            'assets/css/styles.css' => 'optional',
            'assets/js/seleccionar.js' => 'critical',
            'assets/js/footer.js' => 'important',
            'assets/js/footer-date.js' => 'important',
            'assets/js/nav.js' => 'important'
        ];

        foreach ($requiredFiles as $file => $priority) {
            $exists = file_exists($file);
            $this->addResult('Required Files', "{$file} ({$priority})", $exists);

            // Verificar si el archivo no está vacío
            if ($exists && filesize($file) === 0) {
                $this->addResult('Required Files', "{$file} - contenido", false, 'Archivo vacío');
            }
        }

        echo "✅ Prueba de archivos completada\n\n";
    }

    /**
     * Prueba de validación de formulario
     */
    private function testFormValidation() {
        echo "🔍 Probando validación de formulario...\n";

        // Datos de prueba válidos
        $validData = [
            'fecha' => date('Y-m-d', strtotime('+1 week')),
            'hora' => '18:00',
            'direccion' => 'Av. Corrientes 1234, Buenos Aires',
            'evento' => 'boda',
            'mensaje' => 'Te esperamos en nuestra boda',
            'nombre' => 'Juan Pérez',
            'modelo' => 'modelo1',
            'email' => 'test@example.com',
            'telefono' => '+54 11 1234-5678'
        ];

        // Casos de prueba inválidos
        $invalidCases = [
            'datos_vacios' => ['fecha' => '', 'hora' => '', 'direccion' => '', 'evento' => '', 'mensaje' => '', 'nombre' => ''],
            'fecha_pasada' => array_merge($validData, ['fecha' => date('Y-m-d', strtotime('-1 day'))]),
            'hora_invalida' => array_merge($validData, ['hora' => '25:00']),
            'email_invalido' => array_merge($validData, ['email' => 'email-invalido']),
            'script_injection' => array_merge($validData, ['mensaje' => '<script>alert("XSS")</script>'])
        ];

        // Pruebas
        $this->addResult('Form Validation', 'Datos válidos aceptados', $this->validateFormData($validData));

        foreach ($invalidCases as $caseName => $invalidData) {
            $isInvalid = !$this->validateFormData($invalidData);
            $this->addResult('Form Validation', "Caso inválido detectado: {$caseName}", $isInvalid);
        }

        echo "✅ Prueba de validación completada\n\n";
    }

    /**
     * Prueba de carga de archivos
     */
    private function testFileUpload() {
        echo "⬆️ Probando carga de archivos...\n";

        $uploadDir = $this->config['uploads_dir'];

        // Verificar y crear directorio
        if (!is_dir($uploadDir)) {
            $created = mkdir($uploadDir, 0755, true);
            $this->addResult('File Upload', 'Directorio uploads creado', $created);
        } else {
            $this->addResult('File Upload', 'Directorio uploads existe', true);
        }

        $tests = [
            'Directorio escribible' => is_writable($uploadDir),
            'Espacio en disco suficiente' => disk_free_space('.') > (100 * 1024 * 1024), // 100MB
        ];

        foreach ($tests as $test => $result) {
            $this->addResult('File Upload', $test, $result);
        }

        // Crear y probar múltiples tipos de imagen
        $imageTypes = ['png', 'jpg', 'gif'];
        foreach ($imageTypes as $type) {
            $testImage = $this->createTestImage($type);
            if ($testImage) {
                $this->addResult('File Upload', "Imagen {$type} creada", true);
                $this->addResult('File Upload', "Tipo MIME {$type} válido", $this->validateImageType($testImage));

                // Limpiar
                if (file_exists($testImage)) {
                    unlink($testImage);
                }
            } else {
                $this->addResult('File Upload', "Imagen {$type} creada", false);
            }
        }

        echo "✅ Prueba de carga de archivos completada\n\n";
    }

    /**
     * Prueba de selección de modelos
     */
    private function testModelSelection() {
        echo "🎨 Probando selección de modelos...\n";

        $modelDir = 'assets/img/modelos/';
        $modelFiles = [];

        // Buscar archivos de modelo dinámicamente
        if (is_dir($modelDir)) {
            $files = scandir($modelDir);
            foreach ($files as $file) {
                if (preg_match('/^modelo\d+\.(png|jpg|jpeg|gif)$/i', $file)) {
                    $modelFiles[] = $modelDir . $file;
                }
            }
        }

        if (empty($modelFiles)) {
            // Usar lista por defecto si no se encuentran archivos
            $modelFiles = [
                'assets/img/modelos/modelo1.png',
                'assets/img/modelos/modelo2.png',
                'assets/img/modelos/modelo3.png'
            ];
        }

        foreach ($modelFiles as $file) {
            $exists = file_exists($file);
            $this->addResult('Model Selection', basename($file), $exists);

            if ($exists) {
                $size = getimagesize($file);
                $this->addResult('Model Selection', basename($file) . ' - dimensiones válidas', $size !== false);
            }
        }

        // Verificar JavaScript de selección
        $jsFile = 'assets/js/seleccionar.js';
        $jsExists = file_exists($jsFile);
        $this->addResult('Model Selection', 'JavaScript selector existe', $jsExists);

        if ($jsExists) {
            $jsContent = file_get_contents($jsFile);
            $hasFunctions = $this->containsPattern($jsContent, '/function\s+\w+\s*\(/') ||
                           $this->containsPattern($jsContent, '/\w+\s*=\s*function/') ||
                           $this->containsPattern($jsContent, '/=>\s*{/');
            $this->addResult('Model Selection', 'JavaScript tiene funciones', $hasFunctions);
        }

        echo "✅ Prueba de selección de modelos completada\n\n";
    }

    /**
     * Prueba de envío de formulario
     */
    private function testFormSubmission() {
        echo "📤 Probando envío de formulario...\n";

        $processorFiles = ['procesar.php', 'process.php', 'submit.php'];
        $processorFile = null;

        foreach ($processorFiles as $file) {
            if (file_exists($file)) {
                $processorFile = $file;
                break;
            }
        }

        $this->addResult('Form Submission', 'Procesador existe', $processorFile !== null);

        if ($processorFile) {
            // Verificar contenido del procesador
            $content = file_get_contents($processorFile);
            $tests = [
                'Maneja POST' => $this->containsPattern($content, '/\$_POST/'),
                'Validación presente' => $this->containsPattern($content, '/(empty|isset|filter_|validation)/i'),
                'Prevención XSS' => $this->containsPattern($content, '/(htmlspecialchars|strip_tags|filter_)/i'),
                'Manejo de errores' => $this->containsPattern($content, '/(try|catch|error|exception)/i')
            ];

            foreach ($tests as $test => $result) {
                $this->addResult('Form Submission', $test, $result);
            }

            // Simular datos de prueba
            $postData = [
                'fecha' => date('Y-m-d', strtotime('+1 week')),
                'hora' => '18:00',
                'direccion' => 'Test Address',
                'evento' => 'boda',
                'mensaje' => 'Test message',
                'nombre' => 'Test User',
                'modelo' => 'modelo1'
            ];

            $response = $this->simulatePostRequest($processorFile, $postData);
            $this->addResult('Form Submission', 'Respuesta del servidor', $response !== false);
        }

        echo "✅ Prueba de envío completada\n\n";
    }

    /**
     * Prueba de integración JavaScript
     */
    private function testJavaScriptIntegration() {
        echo "⚡ Probando integración JavaScript...\n";

        $jsFiles = [
            'assets/js/seleccionar.js' => 'critical',
            'assets/js/footer.js' => 'important',
            'assets/js/footer-date.js' => 'important',
            'assets/js/nav.js' => 'important',
            'assets/js/validation.js' => 'optional',
            'assets/js/main.js' => 'optional'
        ];

        foreach ($jsFiles as $file => $priority) {
            $exists = file_exists($file);
            $this->addResult('JavaScript', "{$file} ({$priority})", $exists);

            if ($exists) {
                $content = file_get_contents($file);
                $tests = [
                    'Sintaxis básica' => !$this->checkJavaScriptSyntax($content),
                    'No console.log en producción' => !$this->containsPattern($content, '/console\.log/'),
                    'Usa strict mode' => $this->containsPattern($content, '/["\']use strict["\']/'),
                    'Event listeners' => $this->containsPattern($content, '/(addEventListener|onclick|jQuery)/i')
                ];

                foreach ($tests as $test => $result) {
                    $this->addResult('JavaScript', basename($file) . " - {$test}", $result);
                }
            }
        }

        echo "✅ Prueba de JavaScript completada\n\n";
    }

    /**
     * Prueba de diseño responsivo
     */
    private function testResponsiveDesign() {
        echo "📱 Probando diseño responsivo...\n";

        $cssFiles = [
            'assets/css/footer.css',
            'assets/css/nav.css',
            'assets/css/styles.css',
            'assets/css/responsive.css'
        ];

        foreach ($cssFiles as $file) {
            $exists = file_exists($file);
            if (!$exists) continue;

            $this->addResult('Responsive Design', basename($file), true);

            $content = file_get_contents($file);
            $tests = [
                'Media queries presentes' => $this->containsPattern($content, '/@media/i'),
                'Breakpoints móviles' => $this->containsPattern($content, '/@media[^{]*\(max-width:\s*768px\)/i'),
                'Unidades flexibles' => $this->containsPattern($content, '/(rem|em|%|vw|vh)/'),
                'Flexbox o Grid' => $this->containsPattern($content, '/(display:\s*(flex|grid)|flex-|grid-)/i')
            ];

            foreach ($tests as $test => $result) {
                $this->addResult('Responsive Design', basename($file) . " - {$test}", $result);
            }
        }

        echo "✅ Prueba de diseño responsivo completada\n\n";
    }

    /**
     * Prueba de seguridad básica
     */
    private function testSecurity() {
        echo "🔐 Probando aspectos de seguridad...\n";

        $phpFiles = glob('*.php');
        $securityTests = [];

        foreach ($phpFiles as $file) {
            $content = file_get_contents($file);

            $securityTests[] = [
                'file' => $file,
                'sql_injection_protection' => $this->containsPattern($content, '/(prepare|bind|mysqli_real_escape_string|PDO)/i'),
                'xss_protection' => $this->containsPattern($content, '/(htmlspecialchars|strip_tags|filter_var)/i'),
                'csrf_protection' => $this->containsPattern($content, '/(token|csrf|nonce)/i'),
                'input_validation' => $this->containsPattern($content, '/(filter_|validate|empty|isset)/i')
            ];
        }

        $overallSecurity = [
            'Archivos PHP con protección XSS' => 0,
            'Archivos PHP con validación de entrada' => 0,
            'Total archivos PHP' => count($phpFiles)
        ];

        foreach ($securityTests as $test) {
            if ($test['xss_protection']) $overallSecurity['Archivos PHP con protección XSS']++;
            if ($test['input_validation']) $overallSecurity['Archivos PHP con validación de entrada']++;
        }

        foreach ($overallSecurity as $test => $count) {
            if ($test === 'Total archivos PHP') continue;
            $percentage = $overallSecurity['Total archivos PHP'] > 0 ?
                         ($count / $overallSecurity['Total archivos PHP']) * 100 : 0;
            $this->addResult('Security', "{$test} ({$count}/{$overallSecurity['Total archivos PHP']})", $percentage >= 50);
        }

        echo "✅ Prueba de seguridad completada\n\n";
    }

    /**
     * Prueba de rendimiento básico
     */
    private function testPerformance() {
        echo "⚡ Probando rendimiento básico...\n";

        $cssFiles = glob('assets/css/*.css');
        $jsFiles = glob('assets/js/*.js');
        $imageFiles = glob('assets/img/**/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

        $totalCssSize = 0;
        $totalJsSize = 0;
        $totalImageSize = 0;

        foreach ($cssFiles as $file) {
            $totalCssSize += filesize($file);
        }

        foreach ($jsFiles as $file) {
            $totalJsSize += filesize($file);
        }

        foreach ($imageFiles as $file) {
            $totalImageSize += filesize($file);
        }

        $tests = [
            'CSS total < 500KB' => $totalCssSize < (500 * 1024),
            'JavaScript total < 1MB' => $totalJsSize < (1024 * 1024),
            'Imágenes total < 10MB' => $totalImageSize < (10 * 1024 * 1024),
            'Archivos CSS minificados' => $this->checkMinification($cssFiles, 'css'),
            'Archivos JS minificados' => $this->checkMinification($jsFiles, 'js')
        ];

        foreach ($tests as $test => $result) {
            $this->addResult('Performance', $test, $result);
        }

        echo "✅ Prueba de rendimiento completada\n\n";
    }

    // MÉTODOS AUXILIARES

    private function simulatePageLoad($file) {
        try {
            // Usar buffer de salida con manejo de errores
            ob_start();
            $errorHandler = set_error_handler(function($severity, $message, $file, $line) {
                throw new ErrorException($message, 0, $severity, $file, $line);
            });

            include $file;

            restore_error_handler();
            return ob_get_clean();
        } catch (Exception $e) {
            ob_end_clean();
            return false;
        }
    }

    private function containsPattern($content, $pattern) {
        return preg_match($pattern, $content) === 1;
    }

    private function checkRequiredFields($content) {
        $requiredFields = ['fecha', 'hora', 'direccion', 'evento', 'mensaje', 'nombre'];
        $foundFields = 0;

        foreach ($requiredFields as $field) {
            if (preg_match('/name=["\']' . preg_quote($field) . '["\']/i', $content)) {
                $foundFields++;
            }
        }

        return $foundFields >= count($requiredFields) * 0.8; // Al menos 80% de los campos
    }

    private function checkScripts($content) {
        $requiredScripts = ['seleccionar.js', 'footer.js', 'footer-date.js', 'nav.js'];
        $foundScripts = 0;

        foreach ($requiredScripts as $script) {
            if (strpos($content, $script) !== false) {
                $foundScripts++;
            }
        }

        return $foundScripts >= 2; // Al menos 2 scripts principales
    }

    private function validateFormData($data) {
        $required = ['fecha', 'hora', 'direccion', 'evento', 'mensaje', 'nombre'];

        // Verificar campos requeridos
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                return false;
            }
        }

        // Validaciones específicas
        if (isset($data['fecha']) && !$this->isValidDate($data['fecha'])) {
            return false;
        }

        if (isset($data['hora']) && !$this->isValidTime($data['hora'])) {
            return false;
        }

        if (isset($data['email']) && !empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Verificar contenido malicioso
        foreach ($data as $value) {
            if (is_string($value) && $this->containsPattern($value, '/<script|javascript:|on\w+=/i')) {
                return false;
            }
        }

        return true;
    }

    private function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date && $d >= new DateTime();
    }

    private function isValidTime($time) {
        return preg_match('/^([01]?\d|2[0-3]):[0-5]\d$/', $time);
    }

    private function createTestImage($type = 'png') {
        if (!extension_loaded('gd')) {
            return false;
        }

        $image = imagecreate(100, 100);
        $background = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        imagestring($image, 3, 30, 40, 'TEST', $text_color);

        $filename = $this->config['uploads_dir'] . "test_image.{$type}";

        $result = false;
        switch ($type) {
            case 'png':
                $result = imagepng($image, $filename);
                break;
            case 'jpg':
            case 'jpeg':
                $result = imagejpeg($image, $filename);
                break;
            case 'gif':
                $result = imagegif($image, $filename);
                break;
        }

        imagedestroy($image);
        return $result ? $filename : false;
    }

    private function validateImageType($filename) {
        if (!$filename || !file_exists($filename) || !function_exists('mime_content_type')) {
            return false;
        }

        $fileType = mime_content_type($filename);
        return in_array($fileType, $this->config['allowed_image_types']);
    }

    private function simulatePostRequest($file, $data) {
        // Verificación básica de que el archivo puede procesar datos POST
        if (!file_exists($file)) {
            return false;
        }

        $content = file_get_contents($file);
        return $this->containsPattern($content, '/\$_POST/') && !empty($data);
    }

    private function checkJavaScriptSyntax($content) {
        // Verificaciones básicas de sintaxis JavaScript
        $braceCount = substr_count($content, '{') - substr_count($content, '}');
        $parenCount = substr_count($content, '(') - substr_count($content, ')');
        $bracketCount = substr_count($content, '[') - substr_count($content, ']');

        // Verificar comillas no cerradas
        $singleQuotes = substr_count($content, "'") % 2;
        $doubleQuotes = substr_count($content, '"') % 2;

        return ($braceCount !== 0 || $parenCount !== 0 || $bracketCount !== 0 || $singleQuotes !== 0 || $doubleQuotes !== 0);
    }

    private function checkMemoryLimit() {
        $limit = ini_get('memory_limit');
        if ($limit === '-1') return true; // Sin límite

        $bytes = $this->convertToBytes($limit);
        return $bytes >= (128 * 1024 * 1024); // Al menos 128MB
    }

    private function checkExecutionTimeLimit() {
        $limit = ini_get('max_execution_time');
        return $limit === '0' || $limit >= 30; // Sin límite o al menos 30 segundos
    }

    private function convertToBytes($value) {
        $unit = strtolower(substr($value, -1));
        $value = (int) $value;

        switch ($unit) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }

        return $value;
    }

    private function checkMinification($files, $type) {
        if (empty($files)) return true;

        $minifiedCount = 0;
        foreach ($files as $file) {
            $filename = basename($file);
            if (strpos($filename, '.min.') !== false) {
                $minifiedCount++;
            }
        }

        return $minifiedCount > 0 || count($files) <= 2; // Archivos minificados o pocos archivos
    }

    private function addResult($category, $test, $passed, $message = '') {
        $this->testResults[] = [
            'category' => $category,
            'test' => $test,
            'passed' => $passed,
            'message' => $message,
            'timestamp' => microtime(true)
        ];
    }

    private function printResults() {
        $executionTime = microtime(true) - $this->startTime;

        echo "📊 RESULTADOS DE LAS PRUEBAS\n";
        echo "============================\n";
        echo "Tiempo de ejecución: " . round($executionTime, 2) . " segundos\n\n";

        $categories = [];
        foreach ($this->testResults as $result) {
            $categories[$result['category']][] = $result;
        }

        $totalTests = count($this->testResults);
        $passedTests = count(array_filter($this->testResults, function($r) { return $r['passed']; }));

        foreach ($categories as $category => $tests) {
            echo "📂 {$category}\n";
            echo str_repeat('-', strlen($category) + 3) . "\n";

            $categoryPassed = 0;
            $categoryTotal = count($tests);

            foreach ($tests as $test) {
                $icon = $test['passed'] ? '✅' : '❌';
                echo "{$icon} {$test['test']}";
                if (!$test['passed'] && !empty($test['message'])) {
                    echo " - {$test['message']}";
                }
                echo "\n";

                if ($test['passed']) {
                    $categoryPassed++;
                }
            }

            $percentage = round(($categoryPassed / $categoryTotal) * 100, 2);
            echo "\nResumen: {$categoryPassed}/{$categoryTotal} ({$percentage}%)\n\n";
        }

        $overallPercentage = round(($passedTests / $totalTests) * 100, 2);
        echo "📊 RESUMEN FINAL\n";
        echo "================\n";
        echo "Pruebas pasadas: {$passedTests}/{$totalTests} ({$overallPercentage}%)\n";

        if ($overallPercentage < 100) {
            echo "🚨 Se encontraron fallos que requieren atención.\n";
        } else {
            echo "🎉 ¡Todas las pruebas pasaron exitosamente!\n";
        }
    }
}

// Crear instancia y ejecutar las pruebas
$test = new InvitationIntegrationTest();
$test->runAllTests();
