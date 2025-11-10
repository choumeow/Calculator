<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calculator - {{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen p-6">
        <header class="w-full max-w-6xl mx-auto mb-6">
                <nav class="flex items-center justify-end gap-4">
                    @auth
                    <span class="text-[#1b1b18] dark:text-[#EDEDEC] text-sm">
                        Welcome, {{ Auth::user()->username }}!
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Logout
                        </button>
                    </form>
                    @endauth
                </nav>
        </header>

        <div class="max-w-6xl mx-auto">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-sm text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calculator -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-6">
                        <h1 class="text-2xl font-medium mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Calculator</h1>
                        
                        <!-- Display -->
                        <div class="mb-4">
                            <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm p-4 min-h-[80px] flex items-center justify-end">
                                <div id="display" class="text-3xl font-mono text-right text-[#1b1b18] dark:text-[#EDEDEC] w-full overflow-x-auto">0</div>
                            </div>
                            <div id="expression" class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-2 text-right min-h-[20px]"></div>
                        </div>

                        <!-- Calculator Buttons -->
                        <div class="grid grid-cols-4 gap-3">
                            <!-- Row 1 -->
                            <button onclick="clearAll()" class="calc-btn bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-900/30">C</button>
                            <button onclick="clearEntry()" class="calc-btn bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-900/30">CE</button>
                            <button onclick="appendOperator('/')" class="calc-btn bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-900/30">÷</button>
                            <button onclick="appendOperator('*')" class="calc-btn bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-900/30">×</button>
                            
                            <!-- Row 2 -->
                            <button onclick="appendNumber('7')" class="calc-btn">7</button>
                            <button onclick="appendNumber('8')" class="calc-btn">8</button>
                            <button onclick="appendNumber('9')" class="calc-btn">9</button>
                            <button onclick="appendOperator('-')" class="calc-btn bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-900/30">−</button>
                            
                            <!-- Row 3 -->
                            <button onclick="appendNumber('4')" class="calc-btn">4</button>
                            <button onclick="appendNumber('5')" class="calc-btn">5</button>
                            <button onclick="appendNumber('6')" class="calc-btn">6</button>
                            <button onclick="appendOperator('+')" class="calc-btn bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-900/30">+</button>
                            
                            <!-- Row 4 -->
                            <button onclick="appendNumber('1')" class="calc-btn">1</button>
                            <button onclick="appendNumber('2')" class="calc-btn">2</button>
                            <button onclick="appendNumber('3')" class="calc-btn">3</button>
                            <button onclick="calculate()" rowspan="2" class="calc-btn bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-900/30 row-span-2">=</button>
                            
                            <!-- Row 5 -->
                            <button onclick="appendNumber('0')" class="calc-btn col-span-2">0</button>
                            <button onclick="appendDecimal()" class="calc-btn">.</button>
                        </div>
                    </div>
                </div>

                <!-- History -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-6">
                        <h2 class="text-xl font-medium mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">History</h2>
                        <div id="history" class="space-y-2 max-h-[420px] overflow-y-auto">
                            <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">Loading history...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .calc-btn {
                @apply px-4 py-3 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm font-medium text-lg hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] transition-colors;
            }
        </style>

        <script>
            let currentInput = '0';
            let expression = '';
            let lastOperator = null;
            let shouldResetDisplay = false;

            function updateDisplay() {
                document.getElementById('display').textContent = currentInput;
                // Show full expression being built
                const fullExpression = expression + (lastOperator ? ' ' + getDisplayOperator(lastOperator) + ' ' : '');
                document.getElementById('expression').textContent = fullExpression;
            }

            function getDisplayOperator(op) {
                return op === '*' ? '×' : op === '/' ? '÷' : op === '-' ? '−' : op;
            }

            function useHistoryResult(result) {
                // Use the result from history to continue calculation
                currentInput = result;
                expression = '';
                lastOperator = null;
                shouldResetDisplay = false;
                updateDisplay();
            }

            function appendNumber(num) {
                if (shouldResetDisplay) {
                    currentInput = '0';
                    shouldResetDisplay = false;
                }
                if (currentInput === '0') {
                    currentInput = num;
                } else {
                    currentInput += num;
                }
                updateDisplay();
            }

            function appendDecimal() {
                if (shouldResetDisplay) {
                    currentInput = '0';
                    shouldResetDisplay = false;
                }
                if (!currentInput.includes('.')) {
                    currentInput += '.';
                }
                updateDisplay();
            }

            function appendOperator(op) {
                // If there's already an operator and display should reset, 
                // it means user is changing the operator before entering next number
                if (lastOperator && shouldResetDisplay) {
                    // Just replace the operator
                    lastOperator = op;
                    updateDisplay();
                    return;
                }

                // Add current number to expression
                if (expression && lastOperator) {
                    // We have a previous operator, add it and the number
                    expression += ' ' + getDisplayOperator(lastOperator) + ' ' + currentInput;
                } else {
                    // First number in expression
                    expression = currentInput;
                }

                // Store the operator for next operation
                lastOperator = op;
                shouldResetDisplay = true;
                updateDisplay();
            }

            function calculate() {
                // Build complete expression
                let fullExpression = '';
                
                if (expression) {
                    // We have a partial expression, complete it
                    if (lastOperator) {
                        fullExpression = expression + ' ' + getDisplayOperator(lastOperator) + ' ' + currentInput;
                    } else {
                        // Expression exists but no operator - just use the expression result
                        fullExpression = expression;
                    }
                } else {
                    // No expression yet, just use current input
                    fullExpression = currentInput;
                }
                
                const expressionForEval = fullExpression.replace(/×/g, '*').replace(/÷/g, '/').replace(/−/g, '-');
                
                try {
                    const result = Function('"use strict"; return (' + expressionForEval + ')')();
                    const resultStr = result.toString();
                    
                    // Store in database
                    fetch('{{ route("calculator.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            expression: fullExpression + ' =',
                            result: resultStr
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload history to show the new calculation
                            loadHistory();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                    
                    currentInput = resultStr;
                    expression = '';
                    lastOperator = null;
                    shouldResetDisplay = true;
                    updateDisplay();
                } catch (e) {
                    alert('Invalid calculation: ' + e.message);
                    clearAll();
                }
            }

            function clearAll() {
                // Backspace one character from current input
                if (currentInput.length > 1) {
                    currentInput = currentInput.slice(0, -1);
                } else {
                    currentInput = '0';
                }
                shouldResetDisplay = false;
                updateDisplay();
            }

            function clearEntry() {
                currentInput = '0';
                shouldResetDisplay = false;
                updateDisplay();
            }

            function loadHistory() {
                fetch('{{ route("calculator.history") }}')
                    .then(response => response.json())
                    .then(data => {
                        const historyDiv = document.getElementById('history');
                        historyDiv.innerHTML = '';
                        
                        if (data.length === 0) {
                            historyDiv.innerHTML = '<p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">No calculations yet</p>';
                            return;
                        }
                        
                        // Display in descending order (latest first)
                        data.forEach(calc => {
                            const date = new Date(calc.created_at);
                            const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' + 
                                          date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                            
                            const div = document.createElement('div');
                            div.onclick = () => useHistoryResult(calc.result);
                            div.className = 'p-3 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm cursor-pointer hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] transition-colors';
                            div.innerHTML = `
                                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">${calc.expression}</div>
                                <div class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">${calc.result}</div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">${dateStr}</div>
                            `;
                            historyDiv.appendChild(div);
                        });
                    })
                    .catch(error => console.error('Error loading history:', error));
            }

            // Keyboard support
            document.addEventListener('keydown', function(event) {
                // Don't intercept keys if user is typing in an input field
                const activeElement = document.activeElement;
                if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA')) {
                    return;
                }
                
                const key = event.key;
                
                // Number keys (0-9)
                if (key >= '0' && key <= '9') {
                    event.preventDefault();
                    appendNumber(key);
                    return;
                }
                
                // Decimal point
                if (key === '.' || key === ',') {
                    event.preventDefault();
                    appendDecimal();
                    return;
                }
                
                // Operators
                if (key === '+') {
                    event.preventDefault();
                    appendOperator('+');
                    return;
                }
                if (key === '-') {
                    event.preventDefault();
                    appendOperator('-');
                    return;
                }
                if (key === '*') {
                    event.preventDefault();
                    appendOperator('*');
                    return;
                }
                if (key === '/') {
                    event.preventDefault();
                    appendOperator('/');
                    return;
                }
                
                // Calculate (Enter or =)
                if (key === 'Enter' || key === '=') {
                    event.preventDefault();
                    calculate();
                    return;
                }
                
                // Clear all (Escape)
                if (key === 'Escape') {
                    event.preventDefault();
                    clearAll();
                    return;
                }
                
                // Clear entry (Delete or Backspace)
                if (key === 'Delete' || key === 'Backspace') {
                    event.preventDefault();
                    clearEntry();
                    return;
                }
            });

            // Initialize display
            updateDisplay();
            
            // Load history immediately after page loads (non-blocking for login)
            // This allows the login redirect to complete quickly, then load history
            loadHistory();
        </script>
    </body>
</html>
