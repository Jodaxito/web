import React, { useState, useEffect } from 'react';
import {
    View,
    Text,
    ScrollView,
    Image,
    TouchableOpacity,
    StyleSheet,
    SafeAreaView,
    ActivityIndicator,
    Alert,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { StackScreenProps } from '@react-navigation/stack';
import { RootStackNavigator } from '../navigator/StackNav';
import { colors } from '../themes/appTheme';
import { Producto } from '../interfaces/ProductoInterface';
import { productAPI } from '../api/productAPI';
import AsyncStorage from '@react-native-async-storage/async-storage';

type Props = StackScreenProps<RootStackNavigator, 'ProductDetailScreen'>;

export const ProductDetailScreen = ({ route, navigation }: Props) => {
    const { productId } = route.params;
    const [product, setProduct] = useState<Producto | null>(null);
    const [loading, setLoading] = useState(true);
    const [isFavorite, setIsFavorite] = useState(false);

    useEffect(() => {
        loadProduct();
        checkFavorite();
    }, [productId]);

    const checkFavorite = async () => {
        try {
            const favoritesJson = await AsyncStorage.getItem('favorites');
            const favorites: number[] = favoritesJson ? JSON.parse(favoritesJson) : [];
            setIsFavorite(favorites.includes(productId));
        } catch (error) {
            console.error('Error checking favorite:', error);
        }
    };

    const toggleFavorite = async () => {
        try {
            const favoritesJson = await AsyncStorage.getItem('favorites');
            let favorites: number[] = favoritesJson ? JSON.parse(favoritesJson) : [];
            
            if (isFavorite) {
                favorites = favorites.filter(id => id !== productId);
                Alert.alert('Favoritos', 'Producto eliminado de favoritos');
            } else {
                favorites.push(productId);
                Alert.alert('Favoritos', 'Producto agregado a favoritos');
            }
            
            await AsyncStorage.setItem('favorites', JSON.stringify(favorites));
            setIsFavorite(!isFavorite);
        } catch (error) {
            console.error('Error toggling favorite:', error);
        }
    };

    const loadProduct = async () => {
        try {
            setLoading(true);
            const response = await productAPI.getById(productId);
            setProduct(response.data);
        } catch (error) {
            console.error('Error loading product:', error);
            Alert.alert('Error', 'No se pudo cargar el producto');
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <SafeAreaView style={[styles.container, styles.loadingContainer]}>
                <ActivityIndicator size="large" color={colors.primary} />
            </SafeAreaView>
        );
    }

    if (!product) {
        return (
            <SafeAreaView style={styles.container}>
                <Text>Producto no encontrado</Text>
            </SafeAreaView>
        );
    }

    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
                    <Ionicons name="arrow-back" size={24} color={colors.gray} />
                </TouchableOpacity>
                <TouchableOpacity style={styles.favoriteButton} onPress={toggleFavorite}>
                    <Ionicons
                        name={isFavorite ? 'heart' : 'heart-outline'}
                        size={28}
                        color={isFavorite ? colors.error : colors.gray}
                    />
                </TouchableOpacity>
            </View>

            <ScrollView showsVerticalScrollIndicator={false}>
                <View style={styles.imageContainer}>
                    <Image
                        source={{ uri: product.imagen || 'https://via.placeholder.com/300' }}
                        style={styles.productImage}
                    />
                </View>

                <View style={styles.infoContainer}>
                    <Text style={styles.productName}>{product.nombre}</Text>
                    <Text style={styles.productPrice}>
                        {product.tipo_transaccion === 'donacion'
                            ? 'Gratis'
                            : product.tipo_transaccion === 'intercambio'
                                ? 'Intercambio'
                                : `$${product.precio}`}
                    </Text>

                    <View style={styles.section}>
                        <Text style={styles.sectionTitle}>Descripción</Text>
                        <Text style={styles.description}>{product.descripcion}</Text>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionTitle}>Vendedor</Text>
                        <Text style={styles.sellerName}>{product.user?.name}</Text>
                        <Text style={styles.sellerEmail}>{product.user?.email}</Text>
                    </View>
                </View>
            </ScrollView>

            <View style={styles.bottomContainer}>
                <TouchableOpacity style={styles.contactButton}>
                    <Text style={styles.contactButtonText}>Contactar</Text>
                </TouchableOpacity>
            </View>
        </SafeAreaView>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#f9fafb',
    },
    loadingContainer: {
        justifyContent: 'center',
        alignItems: 'center',
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        padding: 16,
        backgroundColor: colors.white,
    },
    backButton: {
        padding: 8,
    },
    favoriteButton: {
        padding: 8,
    },
    imageContainer: {
        marginHorizontal: 16,
        borderRadius: 12,
        overflow: 'hidden',
        marginTop: 16,
    },
    productImage: {
        width: '100%',
        height: 300,
        resizeMode: 'cover',
    },
    infoContainer: {
        padding: 16,
    },
    productName: {
        fontSize: 24,
        fontWeight: 'bold',
        color: '#374151',
        marginBottom: 8,
    },
    productPrice: {
        fontSize: 28,
        fontWeight: 'bold',
        color: colors.primary,
        marginBottom: 16,
    },
    section: {
        marginBottom: 24,
    },
    sectionTitle: {
        fontSize: 18,
        fontWeight: 'bold',
        color: '#374151',
        marginBottom: 8,
    },
    description: {
        fontSize: 16,
        color: colors.gray,
        lineHeight: 24,
    },
    sellerName: {
        fontSize: 18,
        fontWeight: '600',
        color: '#374151',
    },
    sellerEmail: {
        fontSize: 14,
        color: colors.gray,
        marginTop: 4,
    },
    bottomContainer: {
        padding: 16,
        backgroundColor: colors.white,
        borderTopWidth: 1,
        borderTopColor: '#e5e7eb',
    },
    contactButton: {
        backgroundColor: colors.primary,
        borderRadius: 8,
        height: 50,
        justifyContent: 'center',
        alignItems: 'center',
    },
    contactButtonText: {
        color: colors.white,
        fontSize: 18,
        fontWeight: 'bold',
    },
});
