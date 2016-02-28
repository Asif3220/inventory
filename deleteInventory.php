<?php

require_once('auth.php');
include('db.php');
$isDebug = false;
try {
    $isDeleted = 0;
    $id_value = $_GET['id'];

    if (!empty($id_value)) {
        $product_image_path = "";

        $selectInvSql = "SELECT sku, product_image FROM inventory WHERE id=:id_value";
        $selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
        $selectInvSqlParameter = array("id_value" => $id_value);

        if ($isDebug == true) {
            echo "<br>selectInvSql " . $selectInvSql;

            echo "<br>selectInvSqlParameter<pre>";
            print_r($selectInvSqlParameter);
        }



        $selectInvSqlStatement->execute($selectInvSqlParameter);
        $inventoryRecords = array();
        $inventoryRecords = $selectInvSqlStatement->fetchAll();

        if ($isDebug == true) {
            echo '<br><br> errorCode (1): ' . $selectInvSqlStatement->errorCode();

            if ($selectInvSqlStatement->errorCode() > 0) {
                $errors = $selectInvSqlStatement->errorInfo();
                echo '<br><br>selectInvSqlStatement errors (1)<pre>';
                print_r($errors);
                echo '<br><br> selectInvSqlStatement error (1) : ' . ($errors[2]);
            }
        }

        $sku_value = "";

        if (count($inventoryRecords) > 0) {

            $product_image_path = $inventoryRecords[0]["product_image"];
            if ($isDebug == true) {
                echo "<br>product_image_path " . $product_image_path;
            }
            $sku_value = $inventoryRecords[0]["sku"];
            if (!empty($product_image_path)) {
                unlink($product_image_path);
            }
        }

        if ($isDebug == true) {
            echo "<br>sku_value " . $sku_value;
        }



        $deleteInvSql = "DELETE FROM inventory WHERE id=:id_value";
        $deleteInvSqlStatement = $myMySQLPDOCon->prepare($deleteInvSql);
        $deleteInvSqlParameter = array("id_value" => $id_value);

        if ($isDebug == true) {
            echo "<br>deleteInvSql " . $deleteInvSql;
            echo "<br>deleteInvSqlParameter<pre>";
            print_r($deleteInvSqlParameter);
        }

        $deleteInvSqlStatement->execute($deleteInvSqlParameter);

        if ($isDebug == true) {
            echo '<br><br> errorCode (2): ' . $deleteInvSqlStatement->errorCode();

            if ($deleteInvSqlStatement->errorCode() > 0) {
                $errors = $deleteInvSqlStatement->errorInfo();
                echo '<br><br>deleteInvSqlStatement errors (2)<pre>';
                print_r($errors);
                echo '<br><br> deleteInvSqlStatement error (2): ' . ($errors[2]);
            }
        }


        $isDeleted = $deleteInvSqlStatement->rowCount();

        if ($isDebug == true) {
            echo "<br>isDeleted " . $isDeleted;
        }

        if ($isDeleted > 0) {

            if (!empty($sku_value)) {

                $deleteInvSql2 = "DELETE FROM master_inventory WHERE sku=:sku_value";
                $deleteInvSqlStatement2 = $myMySQLPDOCon->prepare($deleteInvSql2);
                $deleteInvSqlParameter2 = array("sku_value" => $sku_value);

                $deleteInvSqlStatement2->execute($deleteInvSqlParameter2);

                if ($isDebug == true) {
                    echo "<br>deleteInvSql2 (3)" . $deleteInvSql2;

                    echo "<br>deleteInvSqlParameter2<pre>";
                    print_r($deleteInvSqlParameter2);

                    echo '<br><br> errorCode (3): ' . $deleteInvSqlStatement2->errorCode();

                    if ($deleteInvSqlStatement2->errorCode() > 0) {
                        $errors = $deleteInvSqlStatement2->errorInfo();
                        echo '<br><br>deleteInvSqlStatement2 errors(3) <pre>';
                        print_r($errors);
                        echo '<br><br> deleteInvSqlStatement2 error (3): ' . ($errors[2]);
                    }
                }

                $isDeleted = $deleteInvSqlStatement2->rowCount();

                if ($isDebug == true) {
                    echo "<br> isDeleted : " . $isDeleted;
                }
            }
        }

        if ($isDebug == true) {
            echo '<br><br> errorCode : ' . $deleteInvSqlStatement->errorCode();

            $errors = $deleteInvSqlStatement->errorInfo();
            echo '<br><br> errorInfo :<br><pre> ';
            print_r($errors);
        }

        if (count($errors) > 0 && count($errors) == 3 && (strpos($errors[2], "Cannot delete or update a parent row: a foreign key constraint fails") !== FALSE)) {
            header("location:inventory.php?invalid=1&message=" . urlencode("Cannot delete as this product is used in the sales order entry! first delete the related sales order entry then delete this product."));
            exit;
        }
    } else {
        if ($isDebug == true) {
            echo "<br> Invalid input";
        } else {
            header("location:inventory.php?invalid=1&message=" . urlencode("Invalid input"));
        }
        exit;
    }
    if ($isDeleted > 0) {
        if ($isDebug == false) {
            header("location:inventory.php?delete=1");
        }
        exit;
    }
} catch (PDOException $e) {
    if ($isDebug == true) {
        echo '<br><br>exception : ' . $e->getMessage();
    } else {
        header("location:inventory.php?invalid=1&message=" . urlencode(" Exception :: " . $e->getMessage()));
    }
    exit;
} catch (Exception $e) {
    if ($isDebug == true) {
        echo "General Error: The inventory record could not be deleted.<br>" . $e->getMessage();
    } else {
        header("location:inventory.php?invalid=1&message=" . urlencode(" Exception :: " . $e->getMessage()));
    }
    exit;
}
?>