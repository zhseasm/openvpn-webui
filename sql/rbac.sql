/*
 Navicat Premium Data Transfer

 Source Server         : openvpn
 Source Server Type    : MySQL
 Source Server Version : 50729
 Source Host           : 192.168.31.121:3306
 Source Schema         : rbac

 Target Server Type    : MySQL
 Target Server Version : 50729
 File Encoding         : 65001

 Date: 19/04/2020 00:52:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access`  (
  `access_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `urls` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of access
-- ----------------------------
INSERT INTO `access` VALUES (0, 'pageone', '[\"\\/index.php\"]');
INSERT INTO `access` VALUES (0, 'pagetwo', '[\"\\/detail.php\"]');
INSERT INTO `access` VALUES (0, 'gateone', '[\"\\/gateone.php\"]');
INSERT INTO `access` VALUES (0, 'vpnconf', '[\"\\/vpnconf.php\"]');
INSERT INTO `access` VALUES (0, 'restoreconf', '[\"\\/restoreconf.php\"]');
INSERT INTO `access` VALUES (0, 'rbacindex', '[\"\\/rbacindex.php\"]');
INSERT INTO `access` VALUES (0, 'normalindex', '[\"\\/normalindex.php\"]');
INSERT INTO `access` VALUES (0, 'userdetail', '[\"\\/userdetail.php\"]');
INSERT INTO `access` VALUES (0, 'rbac', '[\"\\/rbac.php\"]');
INSERT INTO `access` VALUES (0, 'novnc', '[\"\\/novnc.php\"]');
INSERT INTO `access` VALUES (0, 'user', '[\"\\/user.php\"]');
INSERT INTO `access` VALUES (0, 'showca', '[\"\\/showca.php\"]');
INSERT INTO `access` VALUES (0, 'userlist', '[\"\\/UserList.php\"]');
INSERT INTO `access` VALUES (0, 'EditRole', '[\"\\/EditRole.php\"]');
INSERT INTO `access` VALUES (0, 'AccessList', '[\"\\/AccessList.php\"]');
INSERT INTO `access` VALUES (0, 'EditAccess', '[\"\\/EditAccess.php\"]');
INSERT INTO `access` VALUES (0, 'EditUser', '[\"\\/EditUser.php\"]');
INSERT INTO `access` VALUES (0, 'AddUser.php', '[\"\\/rbacAddUser.php\"]');
INSERT INTO `access` VALUES (0, 'RoleList', '[\"\\/RoleList.php\"]');
INSERT INTO `access` VALUES (0, 'Addaccess', '[\"\\/AddAccess.php\"]');
INSERT INTO `access` VALUES (0, 'changeconf', '[\"\\/changeconf.php\"]');
INSERT INTO `access` VALUES (0, 'AddRole', '[\"\\/AddRole.php\"]');
INSERT INTO `access` VALUES (0, 'initnovnc', '[\"\\/initnovnc.php\"]');
INSERT INTO `access` VALUES (0, 'edits2', '[\"\\/edits2.php\"]');
INSERT INTO `access` VALUES (0, 'openvpn', '[\"\\/openvpn.php\"]');
INSERT INTO `access` VALUES (0, 'adduser', '[\"\\/adduser.php\"]');
INSERT INTO `access` VALUES (0, 'adduser', '[\"\\/adduser.php\"]');
INSERT INTO `access` VALUES (0, 'rw1', '[\"\\/rw1.php\"]');
INSERT INTO `access` VALUES (0, 'rw2', '[\"\\/rw2.php\"]');
INSERT INTO `access` VALUES (0, 'rwremove', '[\"\\/rwremove.php\"]');
INSERT INTO `access` VALUES (0, 's2remove', '[\"\\/s2remove.php\"]');
INSERT INTO `access` VALUES (0, 's2s', '[\"\\/s2s.php\"]');
INSERT INTO `access` VALUES (0, 's2s2', '[\"\\/s2s.php\"]');
INSERT INTO `access` VALUES (0, 'updateclinet', '[\"\\/updateclient.php\"]');
INSERT INTO `access` VALUES (0, 'upload', '[\"\\/upload.php\"]');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `role_id` int(11) NOT NULL DEFAULT 0,
  `role_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (0, 'manager');

-- ----------------------------
-- Table structure for role_access
-- ----------------------------
DROP TABLE IF EXISTS `role_access`;
CREATE TABLE `role_access`  (
  `id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NULL DEFAULT NULL,
  `access_id` int(11) NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of role_access
-- ----------------------------
INSERT INTO `role_access` VALUES (0, 0, 0);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1为有效 0无效',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '*70AE3EE89F8BC347D0169983182F30A57EFF1CA1', 1);

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (0, 1, 0);
INSERT INTO `user_role` VALUES (0, 2, 0);
INSERT INTO `user_role` VALUES (0, 3, 0);

SET FOREIGN_KEY_CHECKS = 1;
