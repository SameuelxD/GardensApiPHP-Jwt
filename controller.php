<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos GET, POST, PUT, DELETE, OPTIONS
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Permitir los encabezados Content-Type y Authorization
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Permitir cookies en las solicitudes cruzadas
header("Access-Control-Allow-Credentials: true");

// Manejar solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Establecer los encabezados CORS apropiados
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Length: 0");
    header("Content-Type: text/plain");
    exit();
}

require_once "connection.php";
require_once "auth.jwt.php";

header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$findId = explode('/', $path);
$id = ($path !== '/') ? end($findId) : null;

function sendResponse($statusCode, $data)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


switch ($path) {
    case '/PedidosIncumplidos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                pedidosIncumplidos($conexion);
            });
        });
        break;



    case '/ClientesSinPagos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                clientesSinPagos($conexion);
            });
        });
        break;

    case '/Oficinas1':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isAdmin($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                oficinas1($conexion);
            });
        });
        break;
    case '/ProductosMasVendidos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                productosMasVendidos($conexion);
            });
        });
        break;
    case '/VentasTotales1':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isAdmin($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                ventasTotales1($conexion);
            });
        });
        break;
    case '/ProductoMasVendido':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                productoMasVendido($conexion);
            });
        });
        break;
    case '/ClientesPedidos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                clientesPedidos($conexion);
            });
        });
        break;
    case '/ListaClientes':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isAdmin($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                listaClientes($conexion);
            });
        });
        break;
    case '/EmpleadosSinClientes':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isAdmin($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                empleadosSinClientes($conexion);
            });
        });
        break;
    case '/ProductosSinPedidos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                productosSinPedidos($conexion);
            });
        });
        break;
    case '/Pagos2008Paypal':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                pagos2008Paypal($conexion);
            });
        });

        break;
    case '/FormasPagos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isUser($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                formasPagos($conexion);
            });
        });
        break;
    case '/ClientesPagos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isAdmin($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                clientesPagos($conexion);
            });
        });
        break;
    case '/EmpleadoJefeyJefe':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                empleadoJefeyJefe($conexion);
            });
        });
        break;
    case '/PedidosEstados':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                pedidosEstados($conexion);
            });
        });
        break;
    case '/ClientesPedidosIncumplidos':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                clientesPedidosIncumplidos($conexion);
            });
        });
        break;
    case '/ClientesProductosGamas':
        verifyToken($_REQUEST, function ($statusCode, $data) {
            sendResponse($statusCode, $data);
        }, function ($req) use ($conexion) {
            isModerator($req, function ($statusCode, $data) {
                sendResponse($statusCode, $data);
            }, function () use ($conexion) {
                clientesProductosGamas($conexion);
            });
        });
        break;
    default:
        echo "Ruta Inexistente";
        break;
}


function pedidosIncumplidos($conexion)
{
    $sql = "SELECT * FROM pedido WHERE fecha_esperada < fecha_entrega";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        // Devolver los datos en formato JSON
        echo json_encode($datos);
    } else {
        // Devolver JSON en caso de error
        return json_encode(array('error' => 'Error al mostrar Pedidos Incumplidos'));
    }
}


function clientesSinPagos($conexion)
{
    $sql = "SELECT cli.codigo_cliente AS codigo_cliente, cli.nombre_cliente AS nombre_cliente, emp.codigo_empleado AS codigo_empleado ,emp.nombre AS nombre_empleado,emp.puesto AS puesto_empleado,ofi.codigo_oficina AS codigo_oficina, ofi.ciudad AS ciudad_oficina
            FROM cliente AS cli
            INNER JOIN empleado AS emp ON cli.codigo_empleado_rep_ventas = emp.codigo_empleado
            INNER JOIN oficina AS ofi ON emp.codigo_oficina = ofi.codigo_oficina
            LEFT JOIN pago AS p ON cli.codigo_cliente = p.codigo_cliente
            WHERE p.codigo_cliente IS NULL";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener Clientes sin pagos'));
    }
}


function oficinas1($conexion)
{
    $sql = "SELECT * FROM oficina AS ofi
            WHERE ofi.codigo_oficina NOT IN (
                SELECT emp.codigo_oficina 
                FROM empleado AS emp
                INNER JOIN cliente AS cli ON emp.codigo_empleado = cli.codigo_empleado_rep_ventas
                INNER JOIN pedido AS ped ON cli.codigo_cliente = ped.codigo_cliente
                INNER JOIN detalle_pedido AS det ON ped.codigo_pedido = det.codigo_pedido
                INNER JOIN producto AS prod ON det.codigo_producto = prod.codigo_producto
                WHERE prod.gama = 'Frutales'
            )";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener Oficinas 1'));
    }
}


function productosMasVendidos($conexion)
{
    $sql = "SELECT prod.codigo_producto AS codigo_producto , prod.nombre AS nombre_producto,
    prod.gama AS gama_producto, prod.descripcion AS descripcion_producto , 
    SUM(det.cantidad) AS cantidad_vendida FROM producto AS prod
    INNER JOIN detalle_pedido AS det
    ON prod.codigo_producto = det.codigo_producto
    GROUP BY prod.codigo_producto
    ORDER BY cantidad_vendida DESC
    LIMIT 20";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Productos mas vendidos'));
    }
}

function ventasTotales1($conexion)
{
    $sql = "SELECT prod.codigo_producto AS codigo_producto, prod.nombre AS nombre_producto, 
            SUM(det.cantidad) AS unidades_vendidas,
            SUM(det.cantidad * det.precio_unidad) AS total_facturado,
            SUM(det.cantidad * det.precio_unidad * 0.21) AS total_IVA
            FROM producto AS prod
            INNER JOIN detalle_pedido AS det ON prod.codigo_producto = det.codigo_producto
            GROUP BY prod.codigo_producto
            HAVING total_facturado > 3000
            ORDER BY total_facturado DESC";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $fila['total_facturado_IVA'] = $fila['total_facturado'] + $fila['total_IVA'];
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener las Ventas Totales 1'));
    }
}

function productoMasVendido($conexion)
{
    $sql = "SELECT prod.codigo_producto AS codigo_producto, prod.nombre AS nombre_producto, prod.gama AS gama_producto, prod.descripcion AS descripcion_produto,
    SUM(det.cantidad) AS unidades_vendidas FROM producto AS prod
           INNER JOIN detalle_pedido AS det
           ON prod.codigo_producto = det.codigo_producto
           GROUP BY prod.codigo_producto
           ORDER BY unidades_vendidas DESC 
           LIMIT 1";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener el Producto mas vendido'));
    }
}

function clientesPedidos($conexion)
{
    $sql = "SELECT cli.codigo_cliente AS codigo_cliente, cli.nombre_cliente AS nombre_cliente, 
    COUNT(ped.codigo_cliente) AS cantidad_pedidos 
FROM cliente AS cli
LEFT JOIN pedido AS ped
ON cli.codigo_cliente = ped.codigo_cliente
GROUP BY cli.codigo_cliente
ORDER BY cantidad_pedidos DESC;
";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con la cantidad de pedidos hechos'));
    }
}

function listaClientes($conexion)
{
    $sql = "SELECT cli.codigo_cliente AS codigo_cliente, cli.nombre_cliente AS nombre_cliente, 
    emp.codigo_empleado AS codigo_empleado, ofi.codigo_oficina AS codigo_oficina, 
    ofi.ciudad AS ciudad_oficina
FROM cliente AS cli
INNER JOIN empleado AS emp ON cli.codigo_empleado_rep_ventas = emp.codigo_empleado
INNER JOIN oficina AS ofi ON emp.codigo_oficina = ofi.codigo_oficina;
";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener el listado de Clientes'));
    }
}

function empleadosSinClientes($conexion)
{
    $sql = "SELECT emp.codigo_empleado AS codigo_empleado, emp.nombre AS nombre_empleado, 
    emp.apellido1 AS apellido_empleado, emp.puesto AS puesto_empleado, jef.codigo_empleado AS codigo_jefe, jef.nombre AS nombre_jefe, jef.apellido1 AS apellido_jefe 
    FROM empleado AS emp
    INNER JOIN empleado AS jef ON emp.codigo_jefe = jef.codigo_empleado
    LEFT JOIN cliente AS cli ON emp.codigo_empleado = cli.codigo_empleado_rep_ventas
    WHERE cli.codigo_empleado_rep_ventas IS NULL";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener el Empleados sin clientes asociados'));
    }
}

function productosSinPedidos($conexion)
{
    $sql = "SELECT prod.codigo_producto AS codigo_producto, prod.nombre AS nombre_producto, prod.descripcion AS descripcion_producto, gama.descripcion_texto AS imagen_producto 
    FROM producto AS prod
    INNER JOIN gama_producto AS gama
    ON prod.gama = gama.gama
    LEFT JOIN detalle_pedido AS det ON prod.codigo_producto = det.codigo_producto
    WHERE det.codigo_producto IS NULL";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Productos sin pedidos'));
    }
}

function pagos2008Paypal($conexion)
{
    $sql = "SELECT * FROM pago AS p
        WHERE p.forma_pago = 'Paypal' AND YEAR(p.fecha_pago) = 2008
        ORDER BY p.total DESC";

    $resultado = $conexion->query($sql);
    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Pagos por paypal en el año 2008'));
    }
}

function formasPagos($conexion)
{
    $sql = "SELECT p.forma_pago AS forma_pago FROM pago AS p 
            GROUP BY p.forma_pago";


    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener las formas de pagos disponibles'));
    }
}

function clientesPagos($conexion)
{
    $sql = "SELECT DISTINCT cli.codigo_cliente AS codigo_cliente,cli.nombre_cliente AS nombre_cliente,emp.codigo_empleado AS codigo_empleado,emp.nombre AS nombre_empleado,emp.apellido1 AS apellido_empleado,emp.puesto AS puesto_empleado,ofi.codigo_oficina AS codigo_oficina,ofi.ciudad AS ciudad_oficina FROM cliente AS cli
            INNER JOIN pago AS pag ON cli.codigo_cliente = pag.codigo_cliente
            INNER JOIN empleado AS emp ON cli.codigo_empleado_rep_ventas = emp.codigo_empleado
            INNER JOIN oficina AS ofi ON emp.codigo_oficina = ofi.codigo_oficina";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con pagos'));
    }
}

function empleadoJefeyJefe($conexion)
{
    $sql = "SELECT emp.codigo_empleado AS codigo_empleado,emp.nombre AS nombre_empleado,emp.apellido1 AS apellido_empleado,emp.puesto AS puesto_empleado,jef.codigo_empleado AS codigo_jefe,jef.nombre AS nombre_jefe,jef.apellido1 AS apellido_jefe,jef.puesto AS puesto_jefe,sup.codigo_empleado AS codigo_superior,sup.nombre AS nombre_superior,sup.apellido1 AS apellido_superior,sup.puesto AS puesto_superior FROM empleado AS emp
    INNER JOIN empleado AS jef ON emp.codigo_jefe = jef.codigo_empleado
    INNER JOIN empleado AS sup ON jef.codigo_jefe = sup.codigo_empleado";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con pagos'));
    }
}

function pedidosEstados($conexion)
{
    $sql = "SELECT DISTINCT ped.estado AS estado_pedido,COUNT(ped.estado) AS cantidad_estado FROM pedido AS ped
    GROUP BY estado_pedido
    ORDER BY cantidad_estado DESC";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con pagos'));
    }
}

function clientesPedidosIncumplidos($conexion)
{
    $sql = "SELECT DISTINCT cli.codigo_cliente AS codigo_cliente,cli.nombre_cliente AS nombre_cliente,ped.codigo_pedido AS codigo_pedido,ped.fecha_esperada AS fecha_esperada,ped.fecha_entrega AS fecha_entrega FROM cliente AS cli
    INNER JOIN pedido AS ped ON cli.codigo_cliente = ped.codigo_cliente
    WHERE ped.fecha_esperada<ped.fecha_entrega
    ORDER BY cli.codigo_cliente ASC";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con pedidos incumplidos'));
    }
}

function clientesProductosGamas($conexion)
{
    $sql = "SELECT cli.codigo_cliente AS codigo_cliente,
    cli.nombre_cliente AS nombre_cliente,
    GROUP_CONCAT(DISTINCT prod.gama ORDER BY prod.gama) AS gamas_productos
FROM cliente AS cli
INNER JOIN pedido AS ped ON ped.codigo_cliente = cli.codigo_cliente
INNER JOIN detalle_pedido AS det ON ped.codigo_pedido = det.codigo_pedido
INNER JOIN producto AS prod ON det.codigo_producto = prod.codigo_producto
GROUP BY cli.codigo_cliente, cli.nombre_cliente;
";

    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('error' => 'Error al obtener los Clientes con productos y sus diferentes gamas'));
    }
}
