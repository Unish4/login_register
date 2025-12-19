<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px;
        }
        
        .card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .card h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.4em;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #27ae60, #229954);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .balance-display {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .balance-amount {
            font-size: 2em;
            font-weight: bold;
        }
        
        .transaction-history {
            grid-column: span 2;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .transaction-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .transaction-item.deposit {
            border-left-color: #27ae60;
        }
        
        .transaction-item.withdrawal {
            border-left-color: #e74c3c;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .transaction-history {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏦 Banking System</h1>
            <p>Secure & Reliable Banking Solutions</p>
        </div>
        
        <div class="main-content">
            <!-- Account Selection -->
            <div class="card">
                <h3>Account Management</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Select Account:</label>
                        <select name="account_id" onchange="this.form.submit()">
                            <option value="">Choose Account</option>
                            <?php
                            // Database connection
                            $host = 'localhost';
                            $dbname = 'banking_system';
                            $username = 'root';
                            $password = '';
                            
                            try {
                                $pdo = new PDO("mysql:host=$host", $username, $password);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                
                                // Create database if not exists
                                $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
                                $pdo->exec("USE $dbname");
                                
                                // Create accounts table
                                $pdo->exec("CREATE TABLE IF NOT EXISTS accounts (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    account_number VARCHAR(20) UNIQUE NOT NULL,
                                    account_holder VARCHAR(100) NOT NULL,
                                    balance DECIMAL(15,2) DEFAULT 0.00,
                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                                )");
                                
                                // Create transactions table
                                $pdo->exec("CREATE TABLE IF NOT EXISTS transactions (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    account_id INT NOT NULL,
                                    transaction_type ENUM('deposit', 'withdrawal') NOT NULL,
                                    amount DECIMAL(15,2) NOT NULL,
                                    description TEXT,
                                    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    FOREIGN KEY (account_id) REFERENCES accounts(id)
                                )");
                                
                                // Insert sample accounts if table is empty
                                $stmt = $pdo->query("SELECT COUNT(*) FROM accounts");
                                if ($stmt->fetchColumn() == 0) {
                                    $sampleAccounts = [
                                        ['ACC001', 'John Doe', 5000.00],
                                        ['ACC002', 'Jane Smith', 3500.00],
                                        ['ACC003', 'Bob Johnson', 7500.00],
                                  
                                    ];
                                    
                                    foreach ($sampleAccounts as $account) {
                                        $stmt = $pdo->prepare("INSERT INTO accounts (account_number, account_holder, balance) VALUES (?, ?, ?)");
                                        $stmt->execute($account);
                                    }
                                }
                                
                                // Get all accounts
                                $stmt = $pdo->query("SELECT * FROM accounts ORDER BY account_holder");
                                $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($accounts as $account) {
                                    $selected = (isset($_POST['account_id']) && $_POST['account_id'] == $account['id']) ? 'selected' : '';
                                    echo "<option value='{$account['id']}' $selected>{$account['account_number']} - {$account['account_holder']}</option>";
                                }
                                
                            } catch(PDOException $e) {
                                echo "<option value=''>Database Connection Error</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            
            <?php
            $selectedAccount = null;
            $message = '';
            $messageType = '';
            
            if (isset($_POST['account_id']) && !empty($_POST['account_id'])) {
                $accountId = $_POST['account_id'];
                
                // Get selected account details
                $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
                $stmt->execute([$accountId]);
                $selectedAccount = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Handle deposit
                if (isset($_POST['deposit_amount']) && !empty($_POST['deposit_amount'])) {
                    $amount = floatval($_POST['deposit_amount']);
                    $description = $_POST['deposit_description'] ?? '';
                    
                    if ($amount > 0) {
                        try {
                            $pdo->beginTransaction();
                            
                            // Update account balance
                            $stmt = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
                            $stmt->execute([$amount, $accountId]);
                            
                            // Insert transaction record
                            $stmt = $pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, description) VALUES (?, 'deposit', ?, ?)");
                            $stmt->execute([$accountId, $amount, $description]);
                            
                            $pdo->commit();
                            
                            $message = "Successfully deposited $" . number_format($amount, 2);
                            $messageType = 'success';
                            
                            // Refresh account data
                            $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
                            $stmt->execute([$accountId]);
                            $selectedAccount = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                        } catch(PDOException $e) {
                            $pdo->rollback();
                            $message = "Deposit failed: " . $e->getMessage();
                            $messageType = 'error';
                        }
                    } else {
                        $message = "Please enter a valid amount greater than 0";
                        $messageType = 'error';
                    }
                }
                
                // Handle withdrawal
                if (isset($_POST['withdraw_amount']) && !empty($_POST['withdraw_amount'])) {
                    $amount = floatval($_POST['withdraw_amount']);
                    $description = $_POST['withdraw_description'] ?? '';
                    
                    if ($amount > 0) {
                        if ($amount <= $selectedAccount['balance']) {
                            try {
                                $pdo->beginTransaction();
                                
                                // Update account balance
                                $stmt = $pdo->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
                                $stmt->execute([$amount, $accountId]);
                                
                                // Insert transaction record
                                $stmt = $pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, description) VALUES (?, 'withdrawal', ?, ?)");
                                $stmt->execute([$accountId, $amount, $description]);
                                
                                $pdo->commit();
                                
                                $message = "Successfully withdrawn $" . number_format($amount, 2);
                                $messageType = 'success';
                                
                                // Refresh account data
                                $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
                                $stmt->execute([$accountId]);
                                $selectedAccount = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                            } catch(PDOException $e) {
                                $pdo->rollback();
                                $message = "Withdrawal failed: " . $e->getMessage();
                                $messageType = 'error';
                            }
                        } else {
                            $message = "Insufficient balance. Available balance: $" . number_format($selectedAccount['balance'], 2);
                            $messageType = 'error';
                        }
                    } else {
                        $message = "Please enter a valid amount greater than 0";
                        $messageType = 'error';
                    }
                }
            }
            ?>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($selectedAccount): ?>
                <!-- Balance Display -->
                <div class="card">
                    <h3>Account Balance</h3>
                    <div class="balance-display">
                        <div>Current Balance</div>
                        <div class="balance-amount">$<?php echo number_format($selectedAccount['balance'], 2); ?></div>
                        <small><?php echo $selectedAccount['account_number']; ?> - <?php echo $selectedAccount['account_holder']; ?></small>
                    </div>
                </div>
                
                <!-- Deposit Form -->
                <div class="card">
                    <h3>💰 Make Deposit</h3>
                    <form method="POST">
                        <input type="hidden" name="account_id" value="<?php echo $selectedAccount['id']; ?>">
                        <div class="form-group">
                            <label>Amount ($):</label>
                            <input type="number" name="deposit_amount" step="0.01" min="0.01" placeholder="Enter amount to deposit" required>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional):</label>
                            <input type="text" name="deposit_description" placeholder="Enter transaction description">
                        </div>
                        <button type="submit" class="btn btn-success">Deposit Money</button>
                    </form>
                </div>
                
                <!-- Withdrawal Form -->
                <div class="card">
                    <h3>💳 Make Withdrawal</h3>
                    <form method="POST">
                        <input type="hidden" name="account_id" value="<?php echo $selectedAccount['id']; ?>">
                        <div class="form-group">
                            <label>Amount ($):</label>
                            <input type="number" name="withdraw_amount" step="0.01" min="0.01" max="<?php echo $selectedAccount['balance']; ?>" placeholder="Enter amount to withdraw" required>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional):</label>
                            <input type="text" name="withdraw_description" placeholder="Enter transaction description">
                        </div>
                        <button type="submit" class="btn btn-danger">Withdraw Money</button>
                    </form>
                </div>
                
                <!-- Transaction History -->
                <div class="card transaction-history">
                    <h3>📊 Transaction History</h3>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE account_id = ? ORDER BY transaction_date DESC LIMIT 10");
                    $stmt->execute([$selectedAccount['id']]);
                    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if ($transactions):
                        foreach ($transactions as $transaction):
                    ?>
                        <div class="transaction-item <?php echo $transaction['transaction_type']; ?>">
                            <div>
                                <strong><?php echo ucfirst($transaction['transaction_type']); ?></strong>
                                <?php if ($transaction['description']): ?>
                                    <br><small><?php echo htmlspecialchars($transaction['description']); ?></small>
                                <?php endif; ?>
                                <br><small><?php echo date('M d, Y H:i:s', strtotime($transaction['transaction_date'])); ?></small>
                            </div>
                            <div>
                                <span style="font-size: 1.2em; font-weight: bold; color: <?php echo $transaction['transaction_type'] == 'deposit' ? '#27ae60' : '#e74c3c'; ?>">
                                    <?php echo $transaction['transaction_type'] == 'deposit' ? '+' : '-'; ?>$<?php echo number_format($transaction['amount'], 2); ?>
                                </span>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <p style="text-align: center; color: #666; padding: 20px;">No transactions found for this account.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>