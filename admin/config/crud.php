<?php
include_once 'connection.php';
function checkUsername($connection, $username)
{
    $result = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($result) == 1) {
        return false;
    } else {
        return true;
    }
}
function countData($connection, $table)
{
    $result = mysqli_query($connection, "SELECT * FROM $table");
    return mysqli_num_rows($result);
}
function getData($connection, $table, $id = null)
{
    if ($id) {
        $result = mysqli_query($connection, "SELECT * FROM $table WHERE id='$id'");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM $table");
    }
    if ($result) {
        if (mysqli_num_rows($result)) {
            $row = mysqli_fetch_array($result);
            return $row;
        } else {
            return false;
        }
    }
}
function fetchData($connection, $query)
{
    $result = mysqli_query($connection, $query);
    if ($result) {
        $data = null;
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }
        return $data;
    }
}

function insertData($connection, $table, $data)
{
    $fields = null;
    foreach ($data as $key => $value) {
        $fields .= "$key='$value', ";
    }
    $query = "INSERT INTO $table SET " . substr($fields, 0, -2);
    if (mysqli_query($connection, $query)) {
        return true;
    } else {
        return false;
    }
}

function updateData($connection, $table, $id, $data, $x = null)
{
    $fields = null;
    foreach ($data as $key => $value) {
        $fields .= "$key='$value', ";
    }
    if ($x) {
        $query = "UPDATE $table SET " . substr($fields, 0, -2) . " $x";
    } else {
        if ($id) {
            $query = "UPDATE $table SET " . substr($fields, 0, -2) . " WHERE id = '$id'";
        } else {
            $query = "UPDATE $table SET " . substr($fields, 0, -2);
        }
    }
    if (mysqli_query($connection, $query)) {
        return true;
    } else {
        return false;
    }
}

function deleteData($connection, $table, $id, $image = false, $x = null)
{
    if ($image) {
        $qry = "SELECT image FROM $table WHERE id='$id'";
        $CURRENT = mysqli_fetch_array(mysqli_query($connection, $qry));
        unlink('../images/' . $CURRENT['image']);
    }
    if ($x) {
        $query = "DELETE FROM $table $x";
    } else {
        $query = "DELETE FROM $table WHERE id='$id'";
    }
    if (mysqli_query($connection, $query)) {
        return true;
    } else {
        return false;
    }
}
